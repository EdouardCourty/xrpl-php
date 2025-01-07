<?php

declare(strict_types=1);

namespace XRPL\Model\Ledger;

use XRPL\Model\AbstractResult;

class LedgerCurrent extends AbstractResult
{
    public int $ledgerCurrentIndex;
}
