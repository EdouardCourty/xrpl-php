<?php

declare(strict_types=1);

namespace XRPL\Model\Ledger;

use XRPL\Model\AbstractResult;

class LedgerClosed extends AbstractResult
{
    public string $ledgerHash;
    public int $ledgerIndex;
}
