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

    public function getFieldId(): array
    {
        $header = [];

        if ($this->typeCode < 16) {
            if ($this->nth < 16) {
                $header[] = $this->typeCode << 4 | $this->nth;
            } else {
                $header[] = $this->typeCode << 4;
                $header[] = $this->nth;
            }
        } else {
            if ($this->nth < 16) {
                $header[] = $this->nth;
                $header[] = $this->typeCode;
            } else {
                $header[] = 0;
                $header[] = $this->typeCode;
                $header[] = $this->nth;
            }
        }

        return $header;
    }
}
