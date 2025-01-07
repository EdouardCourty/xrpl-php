<?php

declare(strict_types=1);

namespace XRPL\Model\Account;

use XRPL\Model\AbstractResult;
use XRPL\Model\Account\Nested\Offer;

class AccountOffers extends AbstractResult
{
    public string $account;
    /** @var Offer[] $offers */
    public array $offers = [];
    public ?int $ledgerCurrentIndex = null;
    public ?int $ledgerIndex = null;
    public ?string $ledgerHash = null;
    public mixed $marker = null;
}
