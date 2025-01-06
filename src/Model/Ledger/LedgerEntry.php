<?php

declare(strict_types=1);

namespace XRPL\Model\Ledger;

use XRPL\Model\AbstractResult;

class LedgerEntry extends AbstractResult
{
    public string $index;
    public int $ledgerIndex;
    public ?LedgerEntryNode $node = null;
    public ?string $nodeBinary = null;
    public ?string $deletedLedgerIndex = null;
}
