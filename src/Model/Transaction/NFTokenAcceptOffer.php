<?php

declare(strict_types=1);

namespace XRPL\Model\Transaction;

use XRPL\Model\AbstractTransaction;

/**
 * https://xrpl.org/nftokenacceptoffer.html
 */
class NFTokenAcceptOffer extends AbstractTransaction
{
    public ?string $nFTokenSellOffer = null;
    public ?string $nFTokenBuyOffer = null;
    public ?string $nFTokenBrokerFee = null;
}
