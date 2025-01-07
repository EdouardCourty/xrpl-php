<?php

declare(strict_types=1);

namespace XRPL\Model\Ledger\LedgerEntry;

class LedgerHashes extends AbstractLedgerEntry
{
    public array $hashes = [];
    public ?int $lastLedgerSequence = null;
}
