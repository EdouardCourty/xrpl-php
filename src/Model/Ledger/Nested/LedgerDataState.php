<?php

declare(strict_types=1);

namespace XRPL\Model\Ledger\Nested;

class LedgerDataState
{
    public ?string $data = null;
    public ?string $ledgerEntryType = null;
    public string $index;
}
