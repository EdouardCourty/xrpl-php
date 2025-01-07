<?php

declare(strict_types=1);

namespace XRPL\Model\Ledger\LedgerEntry;

use Symfony\Component\Serializer\Attribute\SerializedName;

class Check extends AbstractLedgerEntry
{
    public string $account;
    public string $destination;
    public ?string $destinationNode = null;
    public ?int $destinationTag = null;
    public ?int $expiration = null;
    public ?string $invoiceId = null;
    public string $ownerNode;
    #[SerializedName('PreviousTxnID')]
    public string $previousTxnID;
    public int $previousTxnLgrSeq;
    public string|array $sendMax; // Check this
    public int $sequence;
    public ?int $sourceTag = null;
}
