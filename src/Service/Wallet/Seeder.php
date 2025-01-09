<?php

declare(strict_types=1);

namespace XRPL\Service\Wallet;

use XRPL\Helper\CryptographyHelper;
use XRPL\ValueObject\Seed;
use XRPL\ValueObject\Wallet;

final class Seeder
{
    public const array ED25519_SEED_PREFIX = [1, 225, 75];
    public const array SECP256K1_SEED = [33];

    public static function generateSeed(): string
    {
        $entropy = self::generateEntropy();

        $seedData = array_merge(self::ED25519_SEED_PREFIX, $entropy);

        $check = CryptographyHelper::doubleSha256(CryptographyHelper::byteArrayToString($seedData));
        $checkBytes = CryptographyHelper::byteStringToArray(bin2hex($check));

        $checkSum = \array_slice($checkBytes, 0, 4);
        $seedBytes = array_merge($seedData, $checkSum);

        $seedString = CryptographyHelper::byteArrayToString($seedBytes);
        return CryptographyHelper::encodeBase58($seedString);
    }

    private static function generateEntropy(int $length = 16): array
    {
        $bytes = bin2hex(random_bytes($length));

        return CryptographyHelper::byteStringToArray($bytes);
    }

    public static function decodeSeed(string $seed): Seed
    {
        $clearSeed = CryptographyHelper::decodeBase58($seed);

        $byteArray = CryptographyHelper::byteStringToArray(bin2hex($clearSeed));
        $checkSum = \array_slice($byteArray, -4);
        $withoutChecksum = \array_slice($byteArray, 0, -4);

        $versionBytesCount = \count(self::ED25519_SEED_PREFIX);
        $prefix = \array_slice($withoutChecksum, 0, $versionBytesCount);
        $payload = \array_slice($withoutChecksum, $versionBytesCount);

        if (\count($payload) !== 16) {
            throw new \Exception('Invalid seed length');
        }

        return new Seed(
            Wallet::ALGORITHM_ED25519,
            $prefix,
            $payload,
            $checkSum,
        );
    }
}
