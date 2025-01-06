<?php

declare(strict_types=1);

namespace XRPL\Type;

/**
 * @author Edouard Courty <edouard.courty2@gmail.com>
 */
final readonly class Hash
{
    public const int LENGTH = 64;

    private string $hash;

    public function __construct(
        string $hash,
    ) {
        if (strlen($hash) !== self::LENGTH) {
            throw new \InvalidArgumentException('Hash must be 64 characters long');
        }

        if (false === preg_match('/^[0-9A-Fa-f]+$/', $hash)) {
            throw new \InvalidArgumentException('Hash must be a Hexadecimal string containing only (0-9, A-F)');
        }

        $this->hash = strtoupper($hash);
    }

    public function __toString(): string
    {
        return $this->getValue();
    }

    public function getValue(): string
    {
        return $this->hash;
    }
}
