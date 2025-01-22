<?php

declare(strict_types=1);

namespace XRPL\ValueObject;

use XRPL\Contract\KeyPairInterface;
use XRPL\Enum\Algorithm;
use XRPL\Service\Wallet\KeyPairGenerator;
use XRPL\Service\Wallet\Seeder;

/**
 * @author Edouard Courty
 */
readonly class KeyPair implements KeyPairInterface
{
    public function __construct(
        #[\SensitiveParameter]
        private string $privateKey,
        #[\SensitiveParameter]
        private string $publicKey,
    ) {
    }

    /**
     * Facade method to generate a random keypair
     */
    public static function generate(Algorithm $algorithm): KeyPairInterface
    {
        $seed = Seeder::generateSeed($algorithm);

        return self::generateFromSeed($seed);
    }

    /**
     * Facade method to generate a keypair from a seed
     */
    public static function generateFromSeed(#[\SensitiveParameter] Seed|string $seed): KeyPairInterface
    {
        if (\is_string($seed)) {
            $seed = Seeder::generateSeedFromString($seed);
        }

        return KeyPairGenerator::generateKeyPair($seed);
    }

    public function getPrivateKey(): string
    {
        return $this->privateKey;
    }

    public function getPublicKey(): string
    {
        return $this->publicKey;
    }
}
