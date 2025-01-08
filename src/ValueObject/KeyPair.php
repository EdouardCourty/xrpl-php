<?php

declare(strict_types=1);

namespace XRPL\ValueObject;

final readonly class KeyPair
{
    public function __construct(
        public string $privateKey,
        public string $publicKey,
    ) {
    }
}
