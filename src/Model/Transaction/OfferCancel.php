<?php

declare(strict_types=1);

namespace XRPL\Model\Transaction;

use XRPL\Model\AbstractTransaction;

/**
 * https://xrpl.org/offercancel.html
 */
class OfferCancel extends AbstractTransaction
{
    public int $offerSequence;
}
