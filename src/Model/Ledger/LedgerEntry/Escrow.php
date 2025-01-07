<?php

declare(strict_types=1);

namespace XRPL\Model\Ledger\LedgerEntry;

use Symfony\Component\Serializer\Attribute\SerializedName;

class Escrow extends AbstractLedgerEntry
{
    public string $account;
    public string $amount;
    public ?int $cancelAfter = null;
    public ?string $condition = null;
    public string $destination;
    public ?string $destinationNode = null;
    public ?int $destinationTag = null;
    public ?int $finishAfter = null;
    public string $ownerNode;
    #[SerializedName('PreviousTxnID')]
    public string $previousTxnID;
    public int $previousTxnLgrSeq;
    public ?int $sourceTag = null;
}
