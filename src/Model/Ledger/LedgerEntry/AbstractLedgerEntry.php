<?php

declare(strict_types=1);

namespace XRPL\Model\Ledger\LedgerEntry;

abstract class AbstractLedgerEntry
{
    public ?string $index = null;
    public string $ledgerEntryType;
    public int $flags;
}
