<?php

declare(strict_types=1);

namespace XRPL\Type;

/**
 * AbstractUintN:
 *  - Stores an unsigned integer in big-endian format.
 *  - Concrete subclasses define the pack/unpack format (e.g. 'C', 'n', 'N').
 *  - Optionally, each subclass can enforce numeric range constraints.
 */
abstract class AbstractUintN extends AbstractBinaryType
{
    protected int $value;

    /**
     * Each subclass provides the correct "pack" format for big-endian:
     *    - 'C' => 8-bit (one unsigned char)
     *    - 'n' => 16-bit big-endian
     *    - 'N' => 32-bit big-endian
     */
    abstract protected function getPackFormat(): string;

    public function __construct(int $intValue)
    {
        $this->value = $intValue;

        // Convert the integer to a packed string using the subclass's format,
        // then unpack to an array of bytes in big-endian order.
        $bytes = unpack('C*', pack($this->getPackFormat(), $intValue));

        if ($bytes === false) {
            throw new \LogicException('Failed to unpack binary data');
        }

        parent::__construct($bytes);
    }

    public function toInt(): int
    {
        // Re-pack the byte array into a binary string.
        $packed = pack('C*', ...$this->getBytes());

        // Unpack with the same format to get the integer back.
        $unpacked = unpack($this->getPackFormat(), $packed);

        if ($unpacked === false) {
            throw new \LogicException('Failed to unpack binary data');
        }

        return reset($unpacked);
    }

    /**
     * Return the raw bytes as a binary string for serialization.
     */
    public function toSerialized(): string
    {
        return pack('C*', ...$this->getBytes());
    }

    public static function fromJson(mixed $data): static
    {
        if (is_numeric($data) === false || \is_int($data) === false) {
            throw new \InvalidArgumentException('UIntN must be numeric');
        }

        return new static($data);
    }
}
