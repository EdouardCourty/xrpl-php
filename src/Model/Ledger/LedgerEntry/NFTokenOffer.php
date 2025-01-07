<?php

declare(strict_types=1);

namespace XRPL\Model\Ledger\LedgerEntry;

use Symfony\Component\Serializer\Attribute\SerializedName;
use XRPL\Model\Common\CurrencyAmount;

class NFTokenOffer extends AbstractLedgerEntry
{
    public CurrencyAmount $amount;
    public ?string $destination = null;
    public ?int $expiration = null;
    public string $NFTokenId;
    public ?string $NFTokenOfferNode = null;
    public string $owner;
    public ?string $ownerNode = null;
    #[SerializedName('PreviousTxnID')]
    public string $previousTxnID;
    public int $previousTxnLgrSeq;
}
