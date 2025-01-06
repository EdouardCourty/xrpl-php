<?php

declare(strict_types=1);

namespace XRPL\Model\Transaction;

use XRPL\Model\AbstractTransaction;

/**
 * https://xrpl.org/escrowcancel.html
 */
class EscrowCancel extends AbstractTransaction
{
    public string $owner;
    public int $offerSequence;
}
