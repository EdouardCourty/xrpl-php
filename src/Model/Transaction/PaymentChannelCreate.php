<?php

declare(strict_types=1);

namespace XRPL\Model\Transaction;

use XRPL\Model\AbstractTransaction;

/**
 * https://xrpl.org/paymentchannelcreate.html
 */
class PaymentChannelCreate extends AbstractTransaction
{
    public string $amount;
    public string $destination;
    public int $settleDelay;
    public string $publicKey;
    public ?int $cancelAfter = null;
    public ?int $destinationTag = null;
}
