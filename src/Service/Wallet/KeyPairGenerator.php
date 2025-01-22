<?php

declare(strict_types=1);

namespace XRPL\Service\Wallet;

use XRPL\Contract\KeyPairInterface;
use XRPL\Enum\Algorithm;
use XRPL\Service\KeyPair\AbstractAlgorithmAwareKeyPairGenerator;
use XRPL\Service\KeyPair\ED25519KeyPairGenerator;
use XRPL\Service\KeyPair\SECP256K19KeyPairGenerator;
use XRPL\ValueObject\Seed;

/**
 * @author Edouard Courty
 */
class KeyPairGenerator
{
    public static function generateKeyPair(#[\SensitiveParameter] Seed $seed): KeyPairInterface
    {
        if ($seed->isValid() === false) {
            throw new \UnexpectedValueException('Invalid seed');
        }

        return self::getKeypairGenerator($seed->algorithm)->deriveKeyPair($seed);
    }

    public static function getKeypairGenerator(Algorithm $algorithm): AbstractAlgorithmAwareKeyPairGenerator
    {
        return match ($algorithm) {
            Algorithm::ED25519 => new ED25519KeyPairGenerator(),
            Algorithm::SECP256K1 => new SECP256K19KeyPairGenerator(),
        };
    }
}
