<?php

declare(strict_types=1);

namespace XRPL\Service\KeyPair;

use Elliptic\EdDSA;
use XRPL\Helper\Cryptography;
use XRPL\ValueObject\KeyPair;
use XRPL\ValueObject\Seed;
use XRPL\ValueObject\Wallet;

/**
 * @author Edouard Courty <edouard.courty2@gmail.com>
 */
class ED25519KeyPairGenerator extends AbstractAlgorithmAwareKeyPairGenerator
{
    public function deriveKeyPair(Seed $seed, bool $validator = false, int $index = 0): KeyPair
    {
        $payload = $seed->payload;

        $halfSha512 = strtoupper(bin2hex(Cryptography::halfSha512(Cryptography::byteArrayToString($payload))));

        $elliptic = new EdDSA($seed->algorithm);
        $rawKeypair = $elliptic->keyFromSecret($halfSha512);

        $privateKey = self::PREFIX_ED25519 . strtoupper($rawKeypair->getSecret('hex'));
        $publicKey = self::PREFIX_ED25519 . strtoupper($rawKeypair->getPublic('hex'));

        return new KeyPair($privateKey, $publicKey);
    }

    public function sign(string $message, string $privateKey): string
    {
        $elliptic = new EdDSA(Wallet::ALGORITHM_ED25519);
        $signed = $elliptic->sign($message, substr($privateKey, 2));

        return $signed->toHex();
    }
}
