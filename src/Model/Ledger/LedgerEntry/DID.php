<?php

declare(strict_types=1);

namespace XRPL\Model\Ledger\LedgerEntry;

use Symfony\Component\Serializer\Attribute\SerializedName;

class DID extends AbstractLedgerEntry
{
    public string $account;
    #[SerializedName('DIDDocument')]
    public ?string $DIDDocument = null;
    public ?string $data = null;
    public string $ownerNode;
    #[SerializedName('PreviousTxnID')]
    public string $previousTxnID;
    public ?int $previousTxnLgrSeq = null;
    #[SerializedName('URI')]
    public ?string $uri;
}
