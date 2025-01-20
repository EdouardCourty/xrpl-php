<?php

declare(strict_types=1);

namespace XRPL\Type;

use XRPL\Service\TransactionEncoder;

/**
 * A Blob is a variable-length, length-prefixed field that can contain arbitrary binary data.
 * Examples include SigningPubKey and TxnSignature fields in XRPL transactions.
 */
class Blob extends AbstractBinaryType
{
    /**
     * @param array<int> $bytes Arbitrary binary data as an array of bytes.
     */
    public function __construct(array $bytes)
    {
        parent::__construct($bytes);
    }

    /**
     * Create a Blob by parsing the length prefix + blob contents from a binary string.
     *
     * @param string $serialized A binary string beginning with the length prefix.
     * @param int    $offset     (optional) The current read offset, which is updated by reference.
     *
     * @return self A new Blob instance with the parsed bytes.
     */
    public static function fromSerialized(string $serialized, int &$offset = 0): self
    {
        [$contentLength, $prefixBytesUsed] = self::decodeLengthPrefix($serialized, $offset);

        $startOfData = $offset + $prefixBytesUsed;
        $dataSegment = substr($serialized, $startOfData, $contentLength);

        if (\strlen($dataSegment) !== $contentLength) {
            throw new \RuntimeException(\sprintf(
                'Blob data is truncated. Expected %d bytes, got %d.',
                $contentLength,
                \strlen($dataSegment),
            ));
        }

        $unpacked = unpack('C*', $dataSegment);

        if ($unpacked === false) {
            throw new \LogicException('Failed to unpack binary data');
        }

        $byteArray = array_values($unpacked);

        $offset = $startOfData + $contentLength;

        return new static($byteArray);
    }

    /**
     * Create a Blob from a normal PHP string. The bytes of the string
     * are taken as-is (raw) and stored in the Blob.
     */
    public static function fromString(string $data): static
    {
        if (ctype_xdigit($data) === false) {
            throw new \InvalidArgumentException('Blob data must be a hex string.');
        }

        $binary = hex2bin($data);

        if ($binary === false) {
            throw new \InvalidArgumentException('Failed to convert hex to binary');
        }

        $unpacked = unpack('C*', $binary);

        if ($unpacked === false) {
            throw new \LogicException('Failed to unpack binary data');
        }

        // Use array_values to reset the indexes to 0, 1, 2, ...
        return new static(array_values($unpacked));
    }

    /**
     * Decode the length prefix from a binary string, given an offset.
     * Returns [ contentLength, prefixBytesUsed ].
     *
     * @param string $data   The binary data (prefix + content).
     * @param int    $offset The current offset into $data.
     *
     * @return array{int, int} [contentLength, bytesUsedForPrefix]
     */
    private static function decodeLengthPrefix(string $data, int $offset): array
    {
        if (!isset($data[$offset])) {
            throw new \RuntimeException('No data available to read the length prefix.');
        }

        $firstByte = \ord($data[$offset]);

        // Case 1: first byte <= 192 => single byte
        if ($firstByte <= 192) {
            $contentLength = $firstByte;
            return [$contentLength, 1];
        }

        // Case 2: first byte in [193..240] => two bytes
        if ($firstByte <= 240) {
            if (!isset($data[$offset + 1])) {
                throw new \RuntimeException('Truncated data: expected 2 bytes for length prefix.');
            }
            $secondByte = \ord($data[$offset + 1]);

            $contentLength = 193
                + (($firstByte - 193) << 8)
                + $secondByte;

            return [$contentLength, 2];
        }

        // Case 3: first byte in [241..254] => three bytes
        if ($firstByte <= 254) {
            if (!isset($data[$offset + 2])) {
                throw new \RuntimeException('Truncated data: expected 3 bytes for length prefix.');
            }
            $secondByte = \ord($data[$offset + 1]);
            $thirdByte  = \ord($data[$offset + 2]);

            $contentLength = 12481
                + (($firstByte - 241) << 16)
                + ($secondByte << 8)
                + $thirdByte;

            return [$contentLength, 3];
        }

        // If first byte = 255 (or >254 for some reason), it's invalid.
        throw new \RuntimeException(\sprintf(
            'Invalid length prefix byte encountered: %d',
            $firstByte,
        ));
    }

    public static function fromJson(mixed $data): static
    {
        if (\is_string($data) === false) {
            throw new \InvalidArgumentException('Blob must be a string');
        }

        return self::fromString($data);
    }
}
