<?php

declare(strict_types=1);

namespace XRPL\Type;

class Hash160 extends AbstractHash
{
    public function __construct(string $hexString)
    {
        parent::__construct($hexString);
    }

    public static function getExpectedLength(): int
    {
        return 20; // 160 bits
    }
}
