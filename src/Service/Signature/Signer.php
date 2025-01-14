<?php

declare(strict_types=1);

namespace XRPL\Service\Signature;

use XRPL\ValueObject\Wallet;

class Signer
{
    public static function sign(string $data, string $privateKey): string
    {

    }

    public static function signMultiSign(string $data, string $privateKey, string $multiSignAddress): string
    {
        return self::sign();
    }

    /**
     * @param string|null $multiSignAddress Leave null for a normal signature
     */
    public static function signTransaction(Wallet $wallet, array $transaction, ?string $multiSignAddress = null): string
    {
        if (is_string($multiSignAddress)) {
            $signerData = [
                'Account' => $multiSignAddress,
                'SigningPubKey' => $wallet->keyPair->publicKey,
                'TxnSignature' =>
            ]
        }
    }
}
