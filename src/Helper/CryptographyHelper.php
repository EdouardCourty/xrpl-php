<?php

declare(strict_types=1);

namespace XRPL\Helper;

class CryptographyHelper
{
    public const string RIPPLE_BASE58_ALPHABET = 'rpshnaf39wBUDNEGHJKLM4PQRST7VWXYZ2bcdeCg65jkm8oFqi1tuvAxyz';

    public static function encodeBase58(string $string): string
    {
        $hex = unpack('H*', $string);
        $hex = reset($hex);
        $decimal = gmp_init($hex, 16);

        $output = '';
        while (gmp_cmp($decimal, 58) >= 0) {
            list($decimal, $mod) = gmp_div_qr($decimal, 58);
            $output .= self::RIPPLE_BASE58_ALPHABET[gmp_intval($mod)];
        }

        if (gmp_cmp($decimal, 0) > 0) {
            $output .= self::RIPPLE_BASE58_ALPHABET[gmp_intval($decimal)];
        }

        $output = strrev($output);

        $bytes = str_split($string);
        foreach ($bytes as $byte) {
            if ($byte === "\x00") {
                $output = self::RIPPLE_BASE58_ALPHABET[0] . $output;
                continue;
            }
            break;
        }

        return $output;
    }

    /**
     * Double SHA-256 of data (returns binary)
     */
    public static function doubleSha256(string $data): string
    {
        return hash('sha256', hash('sha256', $data, true), true);
    }
}
