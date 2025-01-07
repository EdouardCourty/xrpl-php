<?php

declare(strict_types=1);

namespace XRPL\Model\Ledger\LedgerEntry;

use Symfony\Component\Serializer\Attribute\SerializedName;

class MPToken extends AbstractLedgerEntry
{
    public string $account;
    public string $MPTokenInsuranceId;
    public string $MPTAmount;
    #[SerializedName('PreviousTxnID')]
    public string $previousTxnID;
    public int $previousTxnLgrSeq;
    public string $ownerNode;
}
