<?php

declare(strict_types=1);

namespace XRPL\Model\Ledger\LedgerEntry;

use Symfony\Component\Serializer\Attribute\SerializedName;

class PayChannel extends AbstractLedgerEntry
{
    public string $account;
    public string $amount;
    public string $balance;
    public ?int $cancelAfter = null;
    public string $destination;
    public ?int $destinationTag = null;
    public ?string $destinationNode = null;
    public ?int $expiration = null;
    public string $ownerNode;
    #[SerializedName('PreviousTxnID')]
    public string $previousTxnID;
    public int $previousTxnLgrSeq;
    public string $publicKey;
    public int $settleDelay;
    public ?int $sourceTag = null;
}
