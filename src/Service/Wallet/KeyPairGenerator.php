<?php

declare(strict_types=1);

namespace XRPL\Service\Wallet;

use Elliptic\EdDSA;
use XRPL\Helper\CryptographyHelper;
use XRPL\ValueObject\KeyPair;
use XRPL\ValueObject\Seed;
use XRPL\ValueObject\Wallet;

final class KeyPairGenerator
{
    private const string PREFIX_ED25519 = 'ED';

    public static function generateKeyPair(Seed $seed): KeyPair
    {
        $payload = $seed->payload;

        $halfSha512 = strtoupper(bin2hex(CryptographyHelper::halfSha512(CryptographyHelper::byteArrayToString($payload))));

        $elliptic = new EdDSA(Wallet::ALGORITHM_ED25519);
        $rawKeypair = $elliptic->keyFromSecret($halfSha512);

        $privateKey = self::PREFIX_ED25519 . strtoupper($rawKeypair->getSecret('hex'));
        $publicKey = self::PREFIX_ED25519 . strtoupper($rawKeypair->getPublic('hex'));

        return new KeyPair($privateKey, $publicKey);
    }
}
