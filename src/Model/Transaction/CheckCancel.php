<?php

declare(strict_types=1);

namespace XRPL\Model\Transaction;

use XRPL\Model\AbstractTransaction;

/**
 * https://xrpl.org/checkcancel.html
 */
class CheckCancel extends AbstractTransaction
{
    public string $checkID;
}
