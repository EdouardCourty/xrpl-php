<?php

declare(strict_types=1);

namespace XRPL\ValueObject;

readonly class TransactionFieldDefinition
{
    public function __construct(
        public string $name,
        public int $nth,
        public bool $isVLEncoded,
        public bool $isSerialized,
        public bool $isSigningField,
        public string $type,
        public int $typeCode,
    ) {
    }
}
