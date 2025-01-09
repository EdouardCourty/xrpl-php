<?php

declare(strict_types=1);

namespace XRPL\ValueObject;

final readonly class Seed
{
    public function __construct(
        public string $algorithm,
        public array $prefix,
        public array $payload,
        public array $checksum,
    ) {
    }
}
