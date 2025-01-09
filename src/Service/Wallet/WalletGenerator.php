<?php

declare(strict_types=1);

namespace XRPL\Service\Wallet;

use XRPL\ValueObject\Wallet;

final class WalletGenerator
{
    public static function generate(): Wallet
    {
        $seed = Seeder::generateSeed();

        return self::generateFromSeed($seed);
    }

    public static function generateFromSeed(string $seed): Wallet
    {
        $seed = Seeder::decodeSeed($seed);
        $keyPair = KeyPairGenerator::generateKeyPair($seed);

        return new Wallet($seed, $keyPair, AddressService::deriveAddress($keyPair->publicKey));
    }
}
