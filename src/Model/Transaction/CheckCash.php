<?php

declare(strict_types=1);

namespace XRPL\Model\Transaction;

use XRPL\Model\AbstractTransaction;

/**
 * https://xrpl.org/checkcash.html
 */
class CheckCash extends AbstractTransaction
{
    public string $checkID;
    public ?string $amount = null;
    public ?string $deliverMin = null;
}
