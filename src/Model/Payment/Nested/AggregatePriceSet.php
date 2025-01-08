<?php

declare(strict_types=1);

namespace XRPL\Model\Payment\Nested;

class AggregatePriceSet
{
    public string|int|float $mean;
    public int $size;
    public string|int|float $standardDeviation;
}
