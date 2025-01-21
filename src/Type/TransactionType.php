<?php

declare(strict_types=1);

namespace XRPL\Type;

use XRPL\Service\Signature\ServerDefinitions;

/**
 * @author Edouard Courty
 */
class TransactionType extends UInt16
{
    public static function fromString(string $value): static
    {
        return new static(ServerDefinitions::getInstance()->getTransactionType($value));
    }

    public static function fromInteger(int $value): static
    {
        return new static($value);
    }

    public static function fromJson(mixed $data): static
    {
        if (\is_int($data) === true) {
            return self::fromInteger($data);
        }

        return self::fromString((string) $data);
    }
}
