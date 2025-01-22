<?php

declare(strict_types=1);

namespace XRPL\Enum;

/**
 * @author Edouard Courty
 */
enum Algorithm: string
{
    case ED25519 = 'ed25519';
    case SECP256K1 = 'secp256k1';

    public function getPrefix(): array
    {
        return match ($this) {
            self::ED25519 => [1, 225, 75],
            self::SECP256K1 => [33],
        };
    }

    public function getKeyPrefix(): string
    {
        return match($this) {
            self::ED25519 => 'ED',
            self::SECP256K1 => '00',
        };
    }
}
