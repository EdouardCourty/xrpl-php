<?php

declare(strict_types=1);

namespace XRPL\Model\Ledger\LedgerEntry;

use Symfony\Component\Serializer\Attribute\SerializedName;

class DepositPreauth extends AbstractLedgerEntry
{
    public string $account;
    public string $authorize;
    public string $ownerNode;
    #[SerializedName('PreviousTxnID')]
    public string $previousTxnID;
    public int $previousTxnLgrSeq;
}
