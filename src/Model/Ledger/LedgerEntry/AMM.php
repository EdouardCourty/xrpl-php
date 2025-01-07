<?php

declare(strict_types=1);

namespace XRPL\Model\Ledger\LedgerEntry;

use Symfony\Component\Serializer\Attribute\SerializedName;
use XRPL\Model\Common\AMMPoolAsset;
use XRPL\Model\Common\CurrencyAmount;
use XRPL\Model\Ledger\LedgerEntry\Nested\AuctionSlot;
use XRPL\Model\Ledger\LedgerEntry\Nested\VoteEntry;

class AMM extends AbstractLedgerEntry
{
    public AMMPoolAsset $asset;
    public AMMPoolAsset $asset2;
    public string $account;
    public AuctionSlot $auctionSlot;
    public CurrencyAmount $LPTokenBalance;
    #[SerializedName('PreviousTxnID')]
    public ?string $previousTxnID = null;
    public ?string $previousTxnLgrSeq = null;
    public int $tradingFee;
    /** @var VoteEntry[] $voteSlots */
    public array $voteSlots = [];
}
