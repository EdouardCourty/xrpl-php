<?php

declare(strict_types=1);

namespace XRPL\Service\Wallet;

use XRPL\Enum\Algorithm;
use XRPL\Exception\InvalidSeedException;
use XRPL\ValueObject\Seed;
use XRPL\ValueObject\Wallet;

/**
 * @author Edouard Courty
 */
class WalletGenerator
{
    public static function generate(Algorithm $algorithm = Algorithm::ED25519): Wallet
    {
        $seed = Seeder::generateSeed($algorithm);

        return self::generateFromSeed($seed);
    }

    public static function generateFromSeed(#[\SensitiveParameter] Seed|string $seed): Wallet
    {
        if (\is_string($seed)) {
            $seed = Seeder::generateSeedFromString($seed);
        }

        if ($seed->isValid() === false) {
            throw new InvalidSeedException();
        }

        $keyPair = KeyPairGenerator::generateKeyPair($seed);

        return new Wallet($seed, $keyPair, AddressService::deriveAddress($keyPair->getPublicKey()));
    }
}
