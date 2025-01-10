<?php

declare(strict_types=1);

namespace XRPL\Service\Wallet;

use XRPL\Service\KeyPair\AbstractAlgorithmAwareKeyPairGenerator;
use XRPL\Service\KeyPair\ED25519KeyPairGenerator;
use XRPL\Service\KeyPair\SECP256K19KeyPairGenerator;
use XRPL\ValueObject\KeyPair;
use XRPL\ValueObject\Seed;
use XRPL\ValueObject\Wallet;

/**
 * @author Edouard Courty <edouard.courty2@gmail.com>
 */
class KeyPairGenerator
{
    public static function generateKeyPair(#[\SensitiveParameter] Seed $seed): KeyPair
    {
        if ($seed->isValid() === false) {
            throw new \UnexpectedValueException('Invalid seed');
        }

        return self::getKeypairGenerator($seed->algorithm)->deriveKeyPair($seed);
    }

    private static function getKeypairGenerator(string $algorithm): AbstractAlgorithmAwareKeyPairGenerator
    {
        return match ($algorithm) {
            Wallet::ALGORITHM_ED25519 => new ED25519KeyPairGenerator(),
            Wallet::ALGORITHM_SECP256K1 => new SECP256K19KeyPairGenerator(),
            default => throw new \UnexpectedValueException('Unsupported algorithm'),
        };
    }
}
