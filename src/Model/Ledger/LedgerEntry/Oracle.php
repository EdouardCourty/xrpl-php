<?php

declare(strict_types=1);

namespace XRPL\Model\Ledger\LedgerEntry;

use Symfony\Component\Serializer\Attribute\SerializedName;
use XRPL\Model\Transaction\Nested\PriceData;

class Oracle extends AbstractLedgerEntry
{
    public string $owner;
    public string $provider;
    /** @var PriceData[] $priceDataSeries */
    public array $priceDataSeries = [];
    public int $lastUpdateTime;
    #[SerializedName('URI')]
    public ?string $uri = null;
    public string $assetClass;
    public string $ownerNode;
    #[SerializedName('PreviousTxnID')]
    public string $previousTxnID;
    public int $previousTxnLgrSeq;
}
