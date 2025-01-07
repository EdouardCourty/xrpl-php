<?php

declare(strict_types=1);

namespace XRPL\Model\Transaction;

use XRPL\Model\AbstractTransaction;
use XRPL\Model\Common\CurrencyAmount;

/**
 * https://xrpl.org/trustset.html
 */
class TrustSet extends AbstractTransaction
{
    public CurrencyAmount $limitAmount;
    public ?int $qualityIn = null;
    public ?int $qualityOut = null;
}
