<?php

declare(strict_types=1);

namespace XRPL\Model\Account;

use XRPL\Model\AbstractResult;

class GatewayBalances extends AbstractResult
{
    public string $balance;
    public array $obligations = [];
    public array $balances = [];
    public array $assets = [];
    public ?string $ledgerHash = null;
    public ?int $ledgerIndex = null;
    public ?int $ledgerCurrentIndex = null;
}
