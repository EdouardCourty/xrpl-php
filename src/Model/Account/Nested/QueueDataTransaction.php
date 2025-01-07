<?php

declare(strict_types=1);

namespace XRPL\Model\Account\Nested;

class QueueDataTransaction
{
    public bool $authChange;
    public string $fee;
    public string $feeLevel;
    public string $maxSpendDrops;
    public int $seq;
}
