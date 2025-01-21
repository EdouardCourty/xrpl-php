<?php

declare(strict_types=1);

namespace XRPL\Service;

use XRPL\Service\Signature\ServerDefinitions;
use XRPL\Service\Wallet\KeyPairGenerator;
use XRPL\Type\AbstractBinaryType;
use XRPL\Type\AccountID;
use XRPL\Type\Blob;
use XRPL\Type\STObject;
use XRPL\Type\TransactionType;
use XRPL\Utils\SignaturePrefix;
use XRPL\ValueObject\Wallet;

/**
 * @author Edouard Courty
 */
class TransactionEncoder
{
    public static function encodeForMultiSign(array $transactionData, Wallet $wallet): string
    {
        if (isset($transactionData['SigningPubKey']) === true) {
            throw new \LogicException('Cannot multi-sign a transaction containing a SigningPukKey.');
        }

        if (isset($transactionData['Signers']) === true) {
            throw new \LogicException('Cannot multi-sign a transaction containing a Signers entry.');
        }

        $fields = self::getSigningFields($transactionData);
        $fields['SigningPubKey'] = '';

        $signerData = [
            'Account' => $wallet->getAddress(),
            'SigningPubKey' => $wallet->getPublicKey(),
            'TxnSignature' => self::computeSignature(
                $fields,
                $wallet,
                $wallet->getAddress(),
            ),
        ];
        $fields['Signers'] = [['Signer' => $signerData]];

        $serialized = self::serializeFields($fields);
        $sorted = self::sortFields($serialized);

        $transactionArray = [];

        foreach ($sorted as $value) {
            $transactionArray = array_merge($transactionArray, $value);
        }

        $blob = new Blob($transactionArray);
        return $blob->toSerialized(); // Transform the byte array into a uppercase hexadecimal string
    }

    /**
     * @param array<string, AbstractBinaryType> $transactionData
     */
    public static function encodeForSingleSign(array $transactionData, Wallet $wallet): string
    {
        $transactionData['SigningPubKey'] = $wallet->getPublicKey();
        $transactionFields = self::getSigningFields($transactionData);
        $transactionFields['TxnSignature'] = self::computeSignature($transactionFields, $wallet);

        $serializedFields = self::serializeFields($transactionFields);

        $sorted = self::sortFields($serializedFields);

        $transactionArray = [];

        foreach ($sorted as $value) {
            $transactionArray = array_merge($transactionArray, $value);
        }

        $blob = new Blob($transactionArray);
        return $blob->toSerialized(); // Transform the byte array into a uppercase hexadecimal string
    }

    /**
     * @param array<string, mixed> $transactionData
     */
    public static function getSigningFields(array $transactionData): array
    {
        foreach (array_keys($transactionData) as $key) {
            $serverDefinition = ServerDefinitions::getInstance()->getFieldDefinition($key);
            if ($serverDefinition->isSigningField === false) {
                unset($transactionData[$key]);
            }
        }

        return $transactionData;
    }

    public static function serializeFields(array $transactionData): array
    {
        $serializedFields = [];

        foreach ($transactionData as $key => $value) {
            $fieldDefinition = ServerDefinitions::getInstance()->getFieldDefinition($key);
            $fieldId = $fieldDefinition->getFieldId();

            if ($fieldDefinition->name === STObject::ST_OBJECT_END_MARKER) {
                $fieldId = [STObject::ST_OBJECT_END_MARKER_VALUE];
                $serializedFields[$key] = $fieldId;

                continue;
            }

            /** @var class-string<AbstractBinaryType> $class */
            $class = 'XRPL\Type\\' . $fieldDefinition->type;

            if ($key === 'TransactionType') {
                $class = TransactionType::class;
            }

            if (class_exists($class) === false) {
                throw new \InvalidArgumentException(\sprintf('Type %s does not exist.', $class));
            }

            $type = $class::fromJson($value);

            $prefix = [];

            if ($fieldDefinition->isVLEncoded === true) {
                $prefix = self::encodeLengthPrefix($type->getLength());
            }

            $suffix = [];

            if ($fieldDefinition->type === 'STObject') {
                $suffix = [STObject::ST_OBJECT_END_MARKER_VALUE];
            }

            $serializedFields[$key] = array_merge($fieldId, $prefix, $type->getBytes(), $suffix);
        }

        return $serializedFields;
    }

    /**
     * @param array<string, AbstractBinaryType> $transactionData
     */
    public static function sortFields(array $transactionData): array
    {
        $sorted = [];

        foreach ($transactionData as $key => $value) {
            $fieldDefinition = ServerDefinitions::getInstance()->getFieldDefinition($key);

            $sorted[$fieldDefinition->typeCode][$fieldDefinition->nth] = $value;
        }

        array_walk($sorted, function (&$fields) {
            ksort($fields);
        });

        ksort($sorted);

        $finalArray = [];

        foreach ($sorted as $fields) {
            $finalArray = array_merge($finalArray, $fields);
        }

        return $finalArray;
    }

    /**
     * Encode the length according to XRPL variable-length rules:
     *
     * - If length <= 192:
     *       single byte: [ length ]
     * - If 193 <= length <= 12480:
     *       two bytes:
     *         byte1 = 193 + ((length - 193) >> 8)
     *         byte2 = (length - 193) & 0xFF
     * - If 12481 <= length <= 918744:
     *       three bytes:
     *         byte1 = 241 + ((length - 12481) >> 16)
     *         byte2 = ((length - 12481) >> 8) & 0xFF
     *         byte3 = (length - 12481) & 0xFF
     *
     * @param int $length The number of bytes in the content.
     *
     * @return array The encoded length prefix.
     */
    public static function encodeLengthPrefix(int $length): array
    {
        if ($length <= 192) {
            // Single-byte length
            return [$length];
        }

        if ($length <= 12480) {
            // Two-byte prefix
            $delta = $length - 193;
            $byte1 = 193 + ($delta >> 8);
            $byte2 = $delta & 0xFF;
            return [$byte1, $byte2];
        }

        if ($length <= 918744) {
            // Three-byte prefix
            $delta = $length - 12481;
            $byte1 = 241 + ($delta >> 16);
            $byte2 = ($delta >> 8) & 0xFF;
            $byte3 = $delta & 0xFF;
            return [$byte1, $byte2, $byte3];
        }

        throw new \InvalidArgumentException(\sprintf(
            'Blob cannot exceed 918744 bytes. Got length=%d.',
            $length,
        ));
    }

    private static function computeSignature(
        array $transactionData,
        #[\SensitiveParameter] Wallet $wallet,
        ?string $multiSignAddress = null,
    ): string {
        $prefix = dechex($multiSignAddress === null ? SignaturePrefix::TRANSACTION_SIGN : SignaturePrefix::TRANSACTION_MULTISIGN);

        $suffix = '';
        if ($multiSignAddress !== null) {
            $suffix = AccountId::fromJson($multiSignAddress)->toSerialized();
        }

        $serialized = self::serializeFields($transactionData);
        $sorted = self::sortFields($serialized);

        $transactionArray = [];

        foreach ($sorted as $value) {
            $transactionArray = array_merge($transactionArray, $value);
        }

        $blob = new Blob($transactionArray);
        $payload = $prefix . mb_strtoupper($blob->toHex()) . $suffix;

        $keyPairService = KeyPairGenerator::getKeypairGenerator($wallet->seed->algorithm);

        return $keyPairService->sign($payload, $wallet->getPrivateKey());
    }
}
