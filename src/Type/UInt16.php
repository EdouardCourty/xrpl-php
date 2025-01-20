<?php

declare(strict_types=1);

namespace XRPL\Type;

/**
 * UInt16 => 16-bit unsigned integer, 0..65535, big-endian
 */
class UInt16 extends AbstractUintN
{
    public function __construct(int $intValue)
    {
        if ($intValue < 0 || $intValue > 0xFFFF) {
            throw new \InvalidArgumentException("UInt16 out of range: $intValue");
        }

        parent::__construct($intValue);
    }

    protected function getPackFormat(): string
    {
        // 'n' = 16-bit unsigned short (big-endian)
        return 'n';
    }
}
