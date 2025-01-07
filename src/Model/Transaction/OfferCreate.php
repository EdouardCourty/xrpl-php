<?php

declare(strict_types=1);

namespace XRPL\Model\Transaction;

use XRPL\Model\AbstractTransaction;
use XRPL\Model\Common\CurrencyAmount;

/**
 * https://xrpl.org/offercreate.html
 */
class OfferCreate extends AbstractTransaction
{
    public CurrencyAmount $takerGets;
    public CurrencyAmount $takerPays;
    public ?int $expiration = null;
    public ?int $offerSequence = null;
}
