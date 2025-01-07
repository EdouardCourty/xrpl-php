<?php

declare(strict_types=1);

namespace XRPL\Model\Ledger\LedgerEntry;

use Symfony\Component\Serializer\Attribute\SerializedName;

class MPTokenIssuance extends AbstractLedgerEntry
{
    public string $issuer;
    public int $assetScale;
    public string $maximumAmount;
    public string $outstandingAmount;
    public int $transferFee;
    public string $MPTokenMetadata;
    #[SerializedName('PreviousTxnID')]
    public string $previousTxnID;
    public int $previousTxnLgrSeq;
    public string $ownerNode;
    public int $sequence;
}
