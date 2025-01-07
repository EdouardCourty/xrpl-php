<?php

declare(strict_types=1);

namespace XRPL\Model\Ledger\LedgerEntry;

use Symfony\Component\Serializer\Attribute\SerializedName;
use XRPL\Model\Common\CurrencyAmount;

class RippleState extends AbstractLedgerEntry
{
    public CurrencyAmount $balance;
    public CurrencyAmount $highLimit;
    public string $highNode;
    public ?int $highQualityIn = null;
    public ?int $highQualityOut = null;
    public CurrencyAmount $lowLimit;
    public string $lowNode;
    public ?int $lowQualityIn = null;
    public ?int $lowQualityOut = null;
    #[SerializedName('PreviousTxnID')]
    public string $previousTxnID;
    public int $previousTxnLgrSeq;
}
