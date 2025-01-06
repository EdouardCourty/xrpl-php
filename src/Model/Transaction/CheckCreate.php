<?php

declare(strict_types=1);

namespace XRPL\Model\Transaction;

use XRPL\Model\AbstractTransaction;

/**
 * https://xrpl.org/checkcreate.html
 */
class CheckCreate extends AbstractTransaction
{
    public string $destination;
    public string $sendMax;
    public ?int $destinationTag = null;
    public ?int $expiration = null;
    public ?string $invoiceID = null;
}
