<?php

declare(strict_types=1);

namespace XRPL\Type;

class Currency extends AbstractBinaryType
{
    public function __construct(string $symbol)
    {
        if (\strlen($symbol) !== 3) {
            throw new \InvalidArgumentException('Currency symbol must be exactly 3 characters');
        }

        $payload = unpack('C*', $symbol);
        if ($payload === false) {
            throw new \InvalidArgumentException('Unable to unpack currency symbol');
        }

        parent::__construct(array_merge(
            [0x00],
            array_fill(0, 11, 0x00),
            $payload,
            array_fill(0, 5, 0x00),
        ));
    }

    public static function fromJson(mixed $data): static
    {
        if (\is_string($data) === false) {
            throw new \InvalidArgumentException('Currency must be a string');
        }

        return new static($data);
    }
}
