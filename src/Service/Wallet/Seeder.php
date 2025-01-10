<?php

declare(strict_types=1);

namespace XRPL\Service\Wallet;

use XRPL\Helper\Cryptography;
use XRPL\ValueObject\Seed;
use XRPL\ValueObject\Wallet;

/**
 * @author Edouard Courty <edouard.courty2@gmail.com>
 */
class Seeder
{
    public const array ED25519_SEED_PREFIX = [1, 225, 75];
    public const array SECP256K1_SEED_PREFIX = [33];

    private const int ED25519_SEED_LENGTH = 31;
    private const int SECP256K1_SEED_LENGTH = 29;

    private const int SEED_ENTROPY_SIZE = 16;

    private const string ED25519_SEED_STRING_PREFIX = 'sEd';
    private const string SECP256K1_SEED_STRING_PREFIX = 's';

    public const array ALGORITHM_SEED_PREFIX_MAPPING = [
        Wallet::ALGORITHM_ED25519 => self::ED25519_SEED_PREFIX,
        Wallet::ALGORITHM_SECP256K1 => self::SECP256K1_SEED_PREFIX,
    ];

    public static function generateSeed(string $algorithm): Seed
    {
        $bytes = bin2hex(random_bytes(self::SEED_ENTROPY_SIZE));

        $payload = Cryptography::byteStringToArray($bytes);

        $prefix = self::getSeedPrefix($algorithm);
        $seedData = array_merge($prefix, $payload);

        $check = Cryptography::doubleSha256(Cryptography::byteArrayToString($seedData));
        $checkBytes = Cryptography::byteStringToArray(bin2hex($check));

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

        $seedPrefix = self::getSeedPrefix($algorithm);

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

    private static function getSeedPrefix(string $algorithm): array
    {
        if (!isset(self::ALGORITHM_SEED_PREFIX_MAPPING[$algorithm])) {
            throw new \UnexpectedValueException('Unsupported algorithm');
        }

        return self::ALGORITHM_SEED_PREFIX_MAPPING[$algorithm];
    }

    private static function guessAlgorithm(#[\SensitiveParameter] string $seed): string
    {
        if (str_starts_with($seed, self::ED25519_SEED_STRING_PREFIX) && \strlen($seed) === self::ED25519_SEED_LENGTH) {
            return Wallet::ALGORITHM_ED25519;
        }

        if (str_starts_with($seed, self::SECP256K1_SEED_STRING_PREFIX) && \strlen($seed) === self::SECP256K1_SEED_LENGTH) {
            return Wallet::ALGORITHM_SECP256K1;
        }

        throw new \UnexpectedValueException('Unsupported algorithm');
    }
}
