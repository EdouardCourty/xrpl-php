<?php

declare(strict_types=1);

namespace XRPL\Model\Payment\Nested;

use XRPL\Model\Common\CurrencyAmount;

class NFTBuyOffer
{
    public CurrencyAmount $amount;
    public ?int $flags = null;
    public string $nftOfferIndex;
    public string $owner;
}
