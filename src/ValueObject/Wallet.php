<?php

declare(strict_types=1);

namespace XRPL\ValueObject;

final readonly class Wallet
{
    public function __construct(
        public KeyPair $keyPair,
        public string $classicAddress,
        public string $seed,
    ) {
    }
}
