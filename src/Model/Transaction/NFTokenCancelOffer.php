<?php

declare(strict_types=1);

namespace XRPL\Model\Transaction;

use XRPL\Model\AbstractTransaction;

/**
 * https://xrpl.org/nftokencanceloffer.html
 */
class NFTokenCancelOffer extends AbstractTransaction
{
    /**
     * Each element is an NFTokenOffer ID (string) to cancel
     */
    public array $nFTokenOffers = [];
}
