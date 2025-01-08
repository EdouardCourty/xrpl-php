<?php

declare(strict_types=1);

namespace XRPL\Model\Payment;

use XRPL\Model\AbstractResult;
use XRPL\Model\Payment\Nested\NFTBuyOffer;

class NFTBuyOffers extends AbstractResult
{
    public ?string $nftId = null; // Null if NFT is not found
    /** @var NFTBuyOffer[] $offers */
    public array $offers = [];
    public ?int $limit = null;
    public mixed $marker = null;
}
