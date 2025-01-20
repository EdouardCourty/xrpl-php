<?php

declare(strict_types=1);

namespace XRPL\Type;

/**
 * Abstract parent class for all Hash types (Hash128, Hash160, Hash192, Hash256).
 */
abstract class AbstractHash extends AbstractBinaryType
{
    /**
     * @param string $hexString      A hex-encoded string (e.g. "AABBCCDD...").
     */
    public function __construct(
        string $hexString,
    ) {
        // Strip any non-hex characters (e.g. spaces, '0x', etc.)
        $cleanHex = preg_replace('/[^0-9A-Fa-f]/', '', $hexString) ?? '';

        // Must have exactly 2 hex chars per byte
        $cleanHexLength = \strlen($cleanHex);
        if ($cleanHexLength !== 2 * static::getExpectedLength()) {
            throw new \InvalidArgumentException(\sprintf(
                'Hex string must be %d hex chars for a %d-byte hash, got %d chars.',
                2 * static::getExpectedLength(),
                static::getExpectedLength(),
                $cleanHexLength,
            ));
        }

        $binary = hex2bin($cleanHex);
        if ($binary === false) {
            throw new \InvalidArgumentException(\sprintf(
                'Failed to convert hex to binary: "%s"',
                $hexString,
            ));
        }

        $unpacked = unpack('C*', $binary);

        if ($unpacked === false) {
            throw new \LogicException('Failed to unpack binary data');
        }

        // Use array_values to reset the indexes to 0, 1, 2, ...
        parent::__construct(array_values($unpacked));
    }

    public static function fromHex(string $hexString): static
    {
        return new static($hexString);
    }

    public static function fromBinary(string $binary): static
    {
        if (\strlen($binary) !== static::getExpectedLength()) {
            throw new \InvalidArgumentException(\sprintf(
                'Raw binary must be %d bytes, got %d.',
                static::getExpectedLength(),
                \strlen($binary),
            ));
        }

        // Convert the binary to hex, then delegate to constructor
        return new static(bin2hex($binary));
    }

    public static function fromByteArray(array $bytes): static
    {
        if (\count($bytes) !== static::getExpectedLength()) {
            throw new \InvalidArgumentException(\sprintf(
                'Byte array must have %d elements, got %d.',
                static::getExpectedLength(),
                \count($bytes),
            ));
        }

        // Convert the bytes to a binary string
        $binary = pack('C*', ...$bytes);

        // Convert that to hex, call the constructor
        return new static(bin2hex($binary));
    }

    public static function fromJson(mixed $data): static
    {
        if (\is_string($data) === false) {
            throw new \InvalidArgumentException('Hash must be a string');
        }

        return new static($data);
    }

    public abstract static function getExpectedLength(): int;
}
