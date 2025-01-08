<?php

declare(strict_types=1);

namespace XRPL\Model\Payment\Nested;

use XRPL\Model\Common\CurrencyAmount;

class AuctionSlot
{
    public string $account;
    public array $authAccounts = [];
    public string|int $discountedFee;
    public CurrencyAmount $price;
    public string $expiration;
    public int $timeInterval;
}
