<?php

declare(strict_types=1);

namespace XRPL\Model\Ledger\LedgerEntry;

use Symfony\Component\Serializer\Attribute\SerializedName;
use XRPL\Model\Common\CurrencyAmount;

class Offer extends AbstractLedgerEntry
{
    public string $account;
    public string $bookDirectory;
    public string $bookNode;
    public ?int $expiration = null;
    public string $ownerNode;
    #[SerializedName('PreviousTxnID')]
    public string $previousTxnID;
    public int $previousTxnLgrSeq;
    public int $sequence;
    public CurrencyAmount $takerPays;
    public CurrencyAmount $takerGets;
}
