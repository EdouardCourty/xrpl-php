<?php

declare(strict_types=1);

namespace XRPL\Model\Ledger;

use XRPL\Model\AbstractResult;

/**
 * @author Edouard Courty <edouard.courty2@gmail.com>
 */
class LedgerResult extends AbstractResult
{
    public string $ledgerHash;
    public int $ledgerIndex;
    public bool $validated = false;
    public Ledger $ledger;
    public array $queueData = [];
}
