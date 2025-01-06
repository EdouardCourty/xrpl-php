<?php

declare(strict_types=1);

namespace XRPL\Model\Transaction;

use XRPL\Model\AbstractTransaction;
use XRPL\Model\Transaction\Nested\CurrencyAmount;

/**
 * https://xrpl.org/nftokencreateoffer.html
 */
class NFTokenCreateOffer extends AbstractTransaction
{
    public string $nFTokenID;
    public CurrencyAmount $amount;
    public ?string $owner = null;
    public ?string $destination = null;
    public ?int $expiration = null;
}
