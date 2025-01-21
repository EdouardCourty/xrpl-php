<?php

declare(strict_types=1);

namespace XRPL\Type;

/**
 * UInt8 => 8-bit unsigned integer, 0..255
 *
 * @author Edouard Courty
 */
class UInt8 extends AbstractUintN
{
    public function __construct(int $intValue)
    {
        if ($intValue < 0 || $intValue > 0xFF) {
            throw new \InvalidArgumentException("UInt8 out of range: $intValue");
        }

        parent::__construct($intValue);
    }

    protected function getPackFormat(): string
    {
        // 'C' is an 8-bit unsigned char
        return 'C';
    }
}
