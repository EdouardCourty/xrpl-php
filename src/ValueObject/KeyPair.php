<?php

declare(strict_types=1);

namespace XRPL\ValueObject;

use XRPL\Service\Wallet\KeyPairGenerator;
use XRPL\Service\Wallet\Seeder;

/**
 * @author Edouard Courty
 */
readonly class KeyPair
{
    public function __construct(
        #[\SensitiveParameter]
        public string $privateKey,
        #[\SensitiveParameter]
        public string $publicKey,
    ) {
    }

    public static function generate(string $algorithm): self
    {
        $seed = Seeder::generateSeed($algorithm);

        return self::generateFromSeed($seed);
    }

    public static function generateFromSeed(#[\SensitiveParameter] Seed|string $seed): self
    {
        if (\is_string($seed)) {
            $seed = Seeder::generateSeedFromString($seed);
        }

        return KeyPairGenerator::generateKeyPair($seed);
    }
}
