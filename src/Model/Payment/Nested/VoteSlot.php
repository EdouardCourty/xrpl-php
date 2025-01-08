<?php

declare(strict_types=1);

namespace XRPL\Model\Payment\Nested;

class VoteSlot
{
    public string $account;
    public int $tradingFee;
    public int|float $voteWeight;
}
