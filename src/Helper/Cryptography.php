<?php

declare(strict_types=1);

namespace XRPL\Helper;

use StephenHill\Base58;

/**
 * @author Edouard Courty
 */
class Cryptography
{
    public const string RIPPLE_BASE58_ALPHABET = 'rpshnaf39wBUDNEGHJKLM4PQRST7VWXYZ2bcdeCg65jkm8oFqi1tuvAxyz';

    public static function encodeBase58(string $string): string
    {
        $base58 = new Base58(self::RIPPLE_BASE58_ALPHABET);

        return $base58->encode($string);
    }

    public static function decodeBase58(string $string): string
    {
        $base58 = new Base58(self::RIPPLE_BASE58_ALPHABET);

        return $base58->decode($string);
    }

    /**
     * Double SHA-256 of data (returns binary)
     */
    public static function doubleSha256(string $data): string
    {
        return hash('sha256', hash('sha256', $data, true));
    }

    public static function byteStringToArray(string $bytes): array
    {
        if (mb_strlen($bytes) === 0) {
            $bytes = mb_str_pad($bytes, 2, '0', \STR_PAD_LEFT);
        }

        return array_map('hexdec', mb_str_split($bytes, 2));
    }

    public static function byteArrayToString(array $bytes): string
    {
        return implode('', array_map('chr', $bytes));
    }

    public static function halfSha512(string $string): string
    {
        $binaryHash = hash('sha512', $string);

        $encoded = self::byteStringToArray($binaryHash);
        $half = \array_slice($encoded, 0, 32);

        return bin2hex(self::byteArrayToString($half));
    }
}
