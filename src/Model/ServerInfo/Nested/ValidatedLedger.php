<?php

declare(strict_types=1);

namespace XRPL\Model\ServerInfo\Nested;

class ValidatedLedger
{
    public int $baseFee;
    public int $closeTime;
    public string $hash;
    public int $reserveBase;
    public int $reserveInc;
    public int $seq;
}
