<?php

declare(strict_types=1);

namespace XRPL\Type;

/**
 * @author Edouard Courty
 */
class Hash128 extends AbstractHash
{
    public function __construct(string $hexString)
    {
        parent::__construct($hexString);
    }

    public static function getExpectedLength(): int
    {
        return 16; // 128 bits
    }
}
