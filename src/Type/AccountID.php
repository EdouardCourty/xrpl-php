<?php

declare(strict_types=1);

namespace XRPL\Type;

use XRPL\Helper\Cryptography;

/**
 * @author Edouard Courty
 */
class AccountID extends AbstractBinaryType
{
    public function __construct(string $value)
    {
        $deserialized = Cryptography::decodeBase58($value);
        $byteArray = unpack('C*', $deserialized);

        if ($byteArray === false) {
            throw new \LogicException('Failed to unpack binary data');
        }

        // Use array_values to reset the indexes to 0, 1, 2, ...
        parent::__construct(array_values(\array_slice($byteArray, 1, 20)));
    }

    public function getLength(): int
    {
        return 0x14;
    }

    public static function fromJson(mixed $data): static
    {
        if (\is_string($data) === false) {
            throw new \InvalidArgumentException('AccountID must be a string');
        }

        return new static($data);
    }
}
