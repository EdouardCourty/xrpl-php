<?php

declare(strict_types=1);

namespace XRPL\Model\Transaction;

use XRPL\Model\AbstractTransaction;

/**
 * https://xrpl.org/accountdelete.html
 */
class AccountDelete extends AbstractTransaction
{
    public string $destination;
    public ?int $destinationTag = null;
}
