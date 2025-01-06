<?php

declare(strict_types=1);

namespace XRPL\Model\Transaction;

use XRPL\Model\AbstractTransaction;

/**
 * https://xrpl.org/escrowfinish.html
 */
class EscrowFinish extends AbstractTransaction
{
    public string $owner;
    public int $offerSequence;
    public ?string $fulfillment = null;
    public ?string $condition = null;
}
