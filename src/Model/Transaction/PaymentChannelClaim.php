<?php

declare(strict_types=1);

namespace XRPL\Model\Transaction;

use XRPL\Model\AbstractTransaction;

/**
 * https://xrpl.org/paymentchannelclaim.html
 */
class PaymentChannelClaim extends AbstractTransaction
{
    public string $channel;
    public ?string $balance = null;
    public ?string $amount = null;
    public ?string $signature = null;
    public ?string $publicKey = null;
}
