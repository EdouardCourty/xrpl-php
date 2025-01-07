<?php

declare(strict_types=1);

namespace XRPL\Model\Ledger\LedgerEntry;

use Symfony\Component\Serializer\Attribute\SerializedName;

class FeeSettings extends AbstractLedgerEntry
{
    public string $baseFee;
    public int $referenceFeeUnits;
    public int $reserveBase;
    public int $reserveIncrement;
    #[SerializedName('PreviousTxnID')]
    public ?string $previousTxnID = null;
    public ?int $previousTxnLgrSeq = null;
}
