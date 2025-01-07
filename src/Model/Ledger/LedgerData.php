<?php

declare(strict_types=1);

namespace XRPL\Model\Ledger;

use XRPL\Model\AbstractResult;
use XRPL\Model\Ledger\Nested\LedgerDataState;

class LedgerData extends AbstractResult
{
    public int $ledgerIndex;
    public string $ledgerHash;
    /** @var LedgerDataState[] $state */
    public array $state = [];
    public mixed $marker;
}
