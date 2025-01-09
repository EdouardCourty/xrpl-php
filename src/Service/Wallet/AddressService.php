<?php

declare(strict_types=1);

namespace XRPL\Service\Wallet;

use XRPL\Helper\CryptographyHelper;

final class AddressService
{
    private const int ADDRESS_PREFIX_ADDRESS = 0;

    public static function deriveAddress(string $publicKey): string
    {
        $publicKeyBinary = hex2bin($publicKey);

        $hash256 = hash('sha256', $publicKeyBinary, true);
        $hash160 = hash('ripemd160', $hash256, true);
        $hexValue = bin2hex($hash160);

        $byteArray = CryptographyHelper::byteStringToArray($hexValue);
        $sliced = \array_slice($byteArray, 0, 32); // Not sure this is useful, since byteArray is (always) 20 long

        $addressBytes = array_merge([self::ADDRESS_PREFIX_ADDRESS], $sliced);

        $check = CryptographyHelper::doubleSha256(CryptographyHelper::byteArrayToString($addressBytes));
        $checkBytes = CryptographyHelper::byteStringToArray(bin2hex($check));

        $checkSum = \array_slice($checkBytes, 0, 4);
        $seedBytes = array_merge($addressBytes, $checkSum);

        return CryptographyHelper::encodeBase58(CryptographyHelper::byteArrayToString($seedBytes));
    }
}
