<?php

declare(strict_types=1);

namespace XRPL\Model\Transaction;

use XRPL\Model\AbstractTransaction;

/**
 * https://xrpl.org/setregularkey.html
 */
class SetRegularKey extends AbstractTransaction
{
    public ?string $regularKey = null;
}
