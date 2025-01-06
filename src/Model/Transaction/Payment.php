<?php

declare(strict_types=1);

namespace XRPL\Model\Transaction;

use XRPL\Model\AbstractTransaction;
use XRPL\Model\Transaction\Nested\CurrencyAmount;

/**
 * https://xrpl.org/payment.html
 */
class Payment extends AbstractTransaction
{
    public CurrencyAmount $amount;
    public CurrencyAmount $deliverMax;
    public ?CurrencyAmount $deliverMin = null;
    public string $destination;
    public ?int $destinationTag = null;
    public ?string $invoiceID = null;
    public array $paths = [];
    public ?CurrencyAmount $sendMax = null;
}
