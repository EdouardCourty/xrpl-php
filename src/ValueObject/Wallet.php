<?php

declare(strict_types=1);

namespace XRPL\ValueObject;

final readonly class Wallet
{
    public const string ALGORITHM_ED25519 = 'ed25519';
    public const string ALGORITHM_SECP256K1 = 'secp256k1';

    public function __construct(
        public Seed $seed,
        public KeyPair $keyPair,
        public string $classicAddress,
    ) {
    }
}
