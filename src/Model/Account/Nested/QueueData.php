<?php

declare(strict_types=1);

namespace XRPL\Model\Account\Nested;

class QueueData
{
    public int $txnCount;
    public ?bool $authChangeQueued = null;
    public ?int $lowestSequence = null;
    public ?int $highestSequence = null;
    public ?string $maxSpendDropsTotal = null;
    /** @var QueueDataTransaction[] $transactions */
    public array $transactions = [];
}
