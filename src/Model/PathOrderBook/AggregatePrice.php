<?php

declare(strict_types=1);

namespace XRPL\Model\PathOrderBook;

use XRPL\Model\AbstractResult;
use XRPL\Model\PathOrderBook\Nested\AggregatePriceSet;

class AggregatePrice extends AbstractResult
{
    public AggregatePriceSet $entireSet;
    public AggregatePriceSet $trimmedSet;
    public int $time;
}
