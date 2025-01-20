<?php

declare(strict_types=1);

namespace XRPL\Type;

class Hash192 extends AbstractHash
{
    public function __construct(string $hexString)
    {
        parent::__construct($hexString);
    }

    public static function getExpectedLength(): int
    {
        return 24; // 192 bits
    }
}
