<?php

declare(strict_types=1);

namespace XRPL\Model\Transaction;

use XRPL\Model\AbstractTransaction;
use XRPL\Model\Common\CurrencyAmount;

/**
 * https://xrpl.org/escrowcreate.html
 */
class EscrowCreate extends AbstractTransaction
{
    public CurrencyAmount $amount;
    public string $destination;
    public ?int $cancelAfter = null;
    public ?int $finishAfter = null;
    public ?string $condition = null;
    public ?int $destinationTag = null;
}
