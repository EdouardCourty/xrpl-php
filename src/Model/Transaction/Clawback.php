<?php

declare(strict_types=1);

namespace XRPL\Model\Transaction;

use XRPL\Model\AbstractTransaction;
use XRPL\Model\Transaction\Nested\CurrencyAmount;

/**
 * https://xrpl.org/clawback.html
 */
class Clawback extends AbstractTransaction
{
    public CurrencyAmount $amount;
    public ?string $holder = null;
}
