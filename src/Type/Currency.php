<?php

declare(strict_types=1);

namespace XRPL\Type;

/**
 * @author Edouard Courty
 */
class Currency extends AbstractBinaryType
{
    public function __construct(string $symbol)
    {
        $bytes = match(mb_strlen($symbol)) {
            3 => $this->getStandardCodeBytes($symbol),
            40 => $this->getNonStandardCodeBytes($symbol),
            default => throw new \InvalidArgumentException('Currency symbol must be 3 or 40 characters long. You can use the CurrencyConverter to handle the conversion of non-standard currency codes into their hexadecimal formats.'),
        };

        parent::__construct($bytes);
    }

    private function getStandardCodeBytes(string $symbol): array
    {
        $payload = unpack('C*', $symbol);
        if ($payload === false) {
            throw new \InvalidArgumentException('Unable to unpack currency symbol');
        }

        return array_merge(
            [0x00],
            array_fill(0, 11, 0x00),
            $payload,
            array_fill(0, 5, 0x00),
        );
    }

    private function getNonStandardCodeBytes(string $string): array
    {
        $unpacked = unpack('C*', (string) hex2bin($string));
        if ($unpacked === false) {
            throw new \InvalidArgumentException('Unable to unpack currency symbol');
        }

        return $unpacked;
    }

    public static function fromJson(mixed $data): static
    {
        if (\is_string($data) === false) {
            throw new \InvalidArgumentException('Currency must be a string');
        }

        return new static($data);
    }
}
