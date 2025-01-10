<?php
declare(strict_types=1);

namespace XRPL\Model\PathOrderBook\Nested;

use Symfony\Component\Serializer\Attribute\SerializedName;
use XRPL\Model\Common\CurrencyAmount;

/**
 * Shares a few fields with the Offer in the Ledger/LedgerEntry/Offer namespace.
 */
class Offer
{
    public ?string $index = null;
    public string $ledgerEntryType;
    public int $flags;

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
    public ?CurrencyAmount $takerGetsFunded = null;
    public ?CurrencyAmount $takerPaysFunded = null;
    public string $quality;
}
