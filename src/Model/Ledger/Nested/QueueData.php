<?php

declare(strict_types=1);

namespace XRPL\Model\Ledger\Nested;

class QueueData
{
    public string $account;
    public string|array $tx;
    public int $retriesRemaining;
    public string $preflightResult;
    public ?string $lastResult = null;
    public ?bool $authChange = null;
    public ?string $fee = null;
    public ?string $feeLevel = null;
    public ?string $maxSpendDrops = null;
}
