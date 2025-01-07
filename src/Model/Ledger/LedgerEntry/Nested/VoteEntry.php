<?php

declare(strict_types=1);

namespace XRPL\Model\Ledger\LedgerEntry\Nested;

class VoteEntry
{
    public string $account;
    public int $tradingFee;
    public int $voteWeight;
}
