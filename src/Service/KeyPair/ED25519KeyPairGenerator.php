<?php

declare(strict_types=1);

namespace XRPL\Service\KeyPair;

use Elliptic\EdDSA;
use XRPL\Contract\KeyPairInterface;
use XRPL\Enum\Algorithm;
use XRPL\Helper\Cryptography;
use XRPL\ValueObject\KeyPair;
use XRPL\ValueObject\Seed;

/**
 * @author Edouard Courty
 */
class ED25519KeyPairGenerator extends AbstractAlgorithmAwareKeyPairGenerator
{
    public function deriveKeyPair(Seed $seed, bool $validator = false, int $index = 0): KeyPairInterface
    {
        $payload = $seed->payload;

        $halfSha512 = mb_strtoupper(Cryptography::halfSha512(Cryptography::byteArrayToString($payload)));

        $elliptic = new EdDSA(self::getAlgorithm()->value);
        $rawKeypair = $elliptic->keyFromSecret($halfSha512);

        $keyPrefix = self::getAlgorithm()->getKeyPrefix();

        $privateKey = $keyPrefix . mb_strtoupper($rawKeypair->getSecret('hex'));
        $publicKey = $keyPrefix . mb_strtoupper($rawKeypair->getPublic('hex'));

        return new KeyPair($privateKey, $publicKey);
    }

    public function sign(string $message, string $privateKey): string
    {
        $elliptic = new EdDSA(self::getAlgorithm()->value);
        $signed = $elliptic->sign($message, mb_substr($privateKey, 2));

        return $signed->toHex();
    }

    public static function getAlgorithm(): Algorithm
    {
        return Algorithm::ED25519;
    }
}
