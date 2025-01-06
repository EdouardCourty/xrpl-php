<?php

declare(strict_types=1);

namespace XRPL\Model\Transaction;

use XRPL\Model\AbstractTransaction;

/**
 * https://xrpl.org/paymentchannelfund.html
 */
class PaymentChannelFund extends AbstractTransaction
{
    public string $channel;
    public string $amount;
    public ?int $expiration = null;
}
