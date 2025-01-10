<?php

declare(strict_types=1);

namespace XRPL\Model\PathOrderBook\Nested;

class VoteSlot
{
    public string $account;
    public int $tradingFee;
    public int|float $voteWeight;
}
