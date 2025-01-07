<?php

declare(strict_types=1);

namespace XRPL\Model\Ledger;

use XRPL\Model\AbstractResult;
use XRPL\Model\Ledger\LedgerEntry\AbstractLedgerEntry;

class LedgerEntry extends AbstractResult
{
    public string $index;
    public int $ledgerIndex;
    public ?LedgerEntry $node = null;
    public ?string $nodeBinary = null;
    public ?string $deletedLedgerIndex = null;
}
