<?php

declare(strict_types=1);

namespace XRPL\Type;

/**
 * @author Edouard Courty
 */
abstract class AbstractBinaryType
{
    protected function __construct(
        protected array $bytes = [],
    ) {
    }

    public function getBytes(): array
    {
        return $this->bytes;
    }

    public function getLength(): int
    {
        return \count($this->bytes);
    }

    public function toHex(): string
    {
        return bin2hex(pack('C*', ...$this->bytes));
    }

    public function toSerialized(): string
    {
        return mb_strtoupper($this->toHex());
    }

    abstract public static function fromJson(mixed $data): static;
}
