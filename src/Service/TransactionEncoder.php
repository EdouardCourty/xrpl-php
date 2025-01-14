<?php

declare(strict_types=1);

namespace XRPL\Service;

use XRPL\Service\Signature\ServerDefinitions;
use XRPL\Utils\SignaturePrefix;

class TransactionEncoder
{
    public static function encodeForMultiSign(array $transactionData, string $signingAddress): string
    {
        if (false === empty($transactionData['SigningPubKey'])) {
            throw new \LogicException('Trying to multi-sign a transaction with a SigningPukKey is illegal.');
        }

        $fields = self::getSigningFields($transactionData);
        $transactionPrefix = dechex(SignaturePrefix::TRANSACTION_MULTISIGN);

        $transactionSuffix = $signingAddress;

        // TODO: Finish
    }

    public static function encodeForSingleSign(array $transactionData): string
    {
        $transactionPrefix = dechex(SignaturePrefix::TRANSACTION_SIGN);

        $transactionFields = self::getSigningFields($transactionData);
        $transactionFields = self::sortFields($transactionFields);


    }

    private static function getSigningFields(array $transactionData): array
    {
        foreach (array_keys($transactionData) as $key) {
            $serverDefinition = ServerDefinitions::getFieldDefinition($key);
            if ($serverDefinition->isSigningField === false) {
                unset($transactionData[$key]);
            }
        }

        return $transactionData;
    }

    private static function sortFields(array $transactionData): array
    {
        $sorted = [];

        foreach ($transactionData as $key => $value) {
            $fieldDefinition = ServerDefinitions::getInstance()->getFieldDefinition($key);

            $sorted[$fieldDefinition->typeCode][$fieldDefinition->nth] = $value;
        }

        return $sorted;
    }
}
