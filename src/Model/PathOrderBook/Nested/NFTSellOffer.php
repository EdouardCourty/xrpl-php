<?php

declare(strict_types=1);

namespace XRPL\Model\PathOrderBook\Nested;

use XRPL\Model\Common\CurrencyAmount;

class NFTSellOffer
{
    public CurrencyAmount $amount;
    public ?int $flags = null;
    public string $nftOfferIndex;
    public string $owner;
}
