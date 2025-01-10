<?php

declare(strict_types=1);

namespace XRPL\Model\PathOrderBook\Nested;

class AggregatePriceSet
{
    public string|int|float $mean;
    public int $size;
    public string|int|float $standardDeviation;
}
