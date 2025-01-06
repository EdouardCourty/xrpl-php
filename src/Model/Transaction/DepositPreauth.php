<?php

declare(strict_types=1);

namespace XRPL\Model\Transaction;

use XRPL\Model\AbstractTransaction;

/**
 * https://xrpl.org/depositpreauth.html
 */
class DepositPreauth extends AbstractTransaction
{
    public ?string $authorize = null;
    public ?string $unauthorize = null;
}
