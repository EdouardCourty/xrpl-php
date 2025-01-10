<?php

declare(strict_types=1);

namespace XRPL\Model\PathOrderBook\Nested;

use XRPL\Model\Common\CurrencyAmount;

class AMMDescription
{
    public string $account;
    public CurrencyAmount $amount;
    public CurrencyAmount $amount2;
    public ?bool $assetFrozen = null;
    public ?bool $asset2Frozen = null;
    public ?AuctionSlot $auctionSlot = null;
    public CurrencyAmount $lpToken;
    public int $tradingFee;
    /** @var VoteSlot[] */
    public array $voteSlots = [];
}
