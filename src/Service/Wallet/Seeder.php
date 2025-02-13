<?php

declare(strict_types=1);

namespace XRPL\Service\Wallet;

use XRPL\Enum\Algorithm;
use XRPL\Helper\Cryptography;
use XRPL\ValueObject\Seed;

/**
 * @author Edouard Courty
 */
class Seeder
{
    private const int ED25519_SEED_LENGTH = 31;
    private const int SECP256K1_SEED_LENGTH = 29;

    private const int SEED_ENTROPY_SIZE = 16;

    private const string ED25519_SEED_STRING_PREFIX = 'sEd';
    private const string SECP256K1_SEED_STRING_PREFIX = 's';

    public static function generateSeed(Algorithm $algorithm): Seed
    {
        $bytes = bin2hex(random_bytes(self::SEED_ENTROPY_SIZE));

        $payload = Cryptography::byteStringToArray($bytes);

        $prefix = $algorithm->getPrefix();
        $seedData = array_merge($prefix, $payload);

        $check = Cryptography::doubleSha256(Cryptography::byteArrayToString($seedData));
        $checkBytes = Cryptography::byteStringToArray($check);

        $checkSum = \array_slice($checkBytes, 0, 4);

        return new Seed(
            $algorithm,
            $prefix,
            $payload,
            $checkSum,
        );
    }

    public static function generateSeedFromString(#[\SensitiveParameter] string $seed): Seed
    {
        $algorithm = self::guessAlgorithm($seed);

        $clearSeed = Cryptography::decodeBase58($seed);

        $byteArray = Cryptography::byteStringToArray(bin2hex($clearSeed));
        $checkSum = \array_slice($byteArray, -4);
        $withoutChecksum = \array_slice($byteArray, 0, -4);

        $seedPrefix = $algorithm->getPrefix();

        $versionBytesCount = \count($seedPrefix);
        $prefix = \array_slice($withoutChecksum, 0, $versionBytesCount);
        $payload = \array_slice($withoutChecksum, $versionBytesCount);

        if (\count($payload) !== self::SEED_ENTROPY_SIZE) {
            throw new \Exception('Invalid seed length');
        }

        return new Seed(
            $algorithm,
            $prefix,
            $payload,
            $checkSum,
        );
    }

    private static function guessAlgorithm(#[\SensitiveParameter] string $seed): Algorithm
    {
        if (str_starts_with($seed, self::ED25519_SEED_STRING_PREFIX) && mb_strlen($seed) === self::ED25519_SEED_LENGTH) {
            return Algorithm::ED25519;
        }

        if (str_starts_with($seed, self::SECP256K1_SEED_STRING_PREFIX) && mb_strlen($seed) === self::SECP256K1_SEED_LENGTH) {
            return Algorithm::SECP256K1;
        }

        throw new \UnexpectedValueException('Unsupported algorithm');
    }
}
