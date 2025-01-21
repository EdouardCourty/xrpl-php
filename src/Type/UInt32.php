<?php

declare(strict_types=1);

namespace XRPL\Type;

/**
 * UInt32 => 32-bit unsigned integer, 0..4294967295, big-endian
 *
 * @author Edouard Courty
 */
class UInt32 extends AbstractUintN
{
    public function __construct(int $intValue)
    {
        // 0xFFFFFFFF = 4294967295 in decimal
        if ($intValue < 0 || $intValue > 0xFFFFFFFF) {
            throw new \InvalidArgumentException("UInt32 out of range: $intValue");
        }

        parent::__construct($intValue);
    }

    protected function getPackFormat(): string
    {
        // 'N' = 32-bit unsigned long (big-endian)
        return 'N';
    }
}
