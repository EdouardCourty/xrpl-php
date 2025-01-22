<?php

declare(strict_types=1);

namespace XRPL\Service\KeyPair;

use BN\BN;
use Elliptic\EC;
use XRPL\Contract\KeyPairInterface;
use XRPL\Enum\Algorithm;
use XRPL\Helper\Cryptography;
use XRPL\ValueObject\KeyPair;
use XRPL\ValueObject\Seed;

/**
 * @author Edouard Courty
 */
class SECP256K19KeyPairGenerator extends AbstractAlgorithmAwareKeyPairGenerator
{
    private readonly EC $elliptic;

    public function __construct()
    {
        $this->elliptic = new EC(self::getAlgorithm()->value);
    }

    public function deriveKeyPair(Seed $seed, bool $validator = false, int $index = 0): KeyPairInterface
    {
        $payload = $seed->payload;

        $privateKey = $this->derivePrivateKey($payload, $validator, $index);
        $publicKey = $this->elliptic->g->mul(new BN($privateKey, 16))->encodeCompressed('hex');

        $privateKeyPrefix = self::getAlgorithm()->getKeyPrefix();

        return new KeyPair($privateKeyPrefix . mb_strtoupper($privateKey), mb_strtoupper($publicKey));
    }

    private function derivePrivateKey(array $seedPayload, bool $validator, int $index): string
    {
        $privateKeyGenerator = $this->getNumberGenerator($seedPayload);

        if ($validator) {
            return $privateKeyGenerator->toString('hex');
        }

        $publicKeyGenerator = $this->elliptic->g->mul($privateKeyGenerator);

        $byteArray = Cryptography::byteStringToArray($publicKeyGenerator->encodeCompressed('hex'));

        return $this->getNumberGenerator($byteArray, $index)
            ->add($privateKeyGenerator)
            ->mod($this->elliptic->n)
            ->toString('hex');
    }

    public function getNumberGenerator(array $data, ?int $discriminator = null): BN
    {
        $zeroBN = new BN(0);
        $seqBN = $zeroBN->_clone();

        while (true) {
            $seedArray = $data;

            if (\is_int($discriminator)) {
                $seedArray = array_merge($seedArray, Cryptography::byteStringToArray('00000000'));
            }

            $seqHex = mb_str_pad($seqBN->toString('hex'), 8, '00', \STR_PAD_LEFT);
            $seedArray = array_merge($seedArray, Cryptography::byteStringToArray($seqHex));

            $hash = Cryptography::halfSha512(Cryptography::byteArrayToString($seedArray));
            $hashBN = new BN($hash, 16);

            if ($hashBN->cmp($zeroBN) != 0 && $hashBN->cmp($this->elliptic->n) < 0) {
                return $hashBN;
            }

            $seqBN = $seqBN->add(1);
        }
    }

    public function sign(string $message, string $privateKey): string
    {
        $binaryString = hex2bin($message);
        if ($binaryString === false) {
            throw new \InvalidArgumentException('Invalid message');
        }

        $hash = Cryptography::halfSha512($binaryString);

        return $this->elliptic->sign(
            $hash,
            $privateKey,
            'hex',
            ['canonical' => true],
        )->toDER('hex');
    }

    public static function getAlgorithm(): Algorithm
    {
        return Algorithm::SECP256K1;
    }
}
