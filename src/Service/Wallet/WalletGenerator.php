<?php

declare(strict_types=1);

namespace XRPL\Service\Wallet;

use XRPL\Exception\InvalidSeedException;
use XRPL\ValueObject\Seed;
use XRPL\ValueObject\Wallet;

/**
 * @author Edouard Courty
 */
class WalletGenerator
{
    private const array SUPPORTED_ALGORITHMS = [
        Wallet::ALGORITHM_ED25519,
        Wallet::ALGORITHM_SECP256K1,
    ];

    public static function generate(string $algorithm = Wallet::ALGORITHM_ED25519): Wallet
    {
        if (false === \in_array($algorithm, self::SUPPORTED_ALGORITHMS, true)) {
            throw new \UnexpectedValueException('Unsupported algorithm');
        }

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

        return new Wallet($seed, $keyPair, AddressService::deriveAddress($keyPair->publicKey));
    }
}
