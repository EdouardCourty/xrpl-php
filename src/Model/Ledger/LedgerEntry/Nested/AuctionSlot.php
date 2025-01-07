<?php

declare(strict_types=1);

namespace XRPL\Model\Ledger\LedgerEntry\Nested;

use XRPL\Model\Common\CurrencyAmount;

class AuctionSlot
{
    public string $account;
    public array $authAccounts = [];
    public string $discountedFee;
    public CurrencyAmount $price;
    public string $expiration;
}
