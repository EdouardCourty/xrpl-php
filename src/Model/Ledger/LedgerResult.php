<?php

declare(strict_types=1);

namespace XRPL\Model\Ledger;

use XRPL\Model\AbstractResult;
use XRPL\Model\Ledger\Nested\Ledger;
use XRPL\Model\Ledger\Nested\QueueData;

/**
 * @author Edouard Courty <edouard.courty2@gmail.com>
 */
class LedgerResult extends AbstractResult
{
    public string $ledgerHash;
    public int $ledgerIndex;
    public bool $validated = false;
    public Ledger $ledger;
    /** @var QueueData[] $queueData */
    public array $queueData = [];
}
