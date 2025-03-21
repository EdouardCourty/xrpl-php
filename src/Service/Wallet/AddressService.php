<?php

declare(strict_types=1);

namespace XRPL\Service\Wallet;

use XRPL\Helper\Cryptography;

/**
 * @author Edouard Courty
 */
class AddressService
{
    private const int ADDRESS_PREFIX_ADDRESS = 0;

    public static function deriveAddress(#[\SensitiveParameter] string $publicKey): string
    {
        $publicKeyBinary = hex2bin($publicKey);

        if ($publicKeyBinary === false) {
            throw new \InvalidArgumentException('Invalid public key');
        }

        $hash256 = hash('sha256', $publicKeyBinary, true);
        $hash160 = hash('ripemd160', $hash256, true);
        $hexValue = bin2hex($hash160);

        $byteArray = Cryptography::byteStringToArray($hexValue);
        $sliced = \array_slice($byteArray, 0, 32);

        $addressBytes = array_merge([self::ADDRESS_PREFIX_ADDRESS], $sliced);

        $check = Cryptography::doubleSha256(Cryptography::byteArrayToString($addressBytes));
        $checkBytes = Cryptography::byteStringToArray($check);

        $checkSum = \array_slice($checkBytes, 0, 4);
        $seedBytes = array_merge($addressBytes, $checkSum);

        return Cryptography::encodeBase58(Cryptography::byteArrayToString($seedBytes));
    }
}
