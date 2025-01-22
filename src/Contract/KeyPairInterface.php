<?php

declare(strict_types=1);

namespace XRPL\Contract;

use XRPL\ValueObject\KeyPair;

/**
 * @author Edouard Courty
 *
 * A key pair is composed of a private key and a public key.
 * The private key is used to sign transactions and the public key is used to verify the signature.
 *
 * @see KeyPair for a basic implementation of a key pair, but you can implement your own if you want.
 */
interface KeyPairInterface
{
    public function getPrivateKey(): string;
    public function getPublicKey(): string;
}
