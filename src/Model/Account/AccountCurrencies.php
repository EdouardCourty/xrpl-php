<?php

declare(strict_types=1);

namespace XRPL\Model\Account;

use XRPL\Model\AbstractResult;

class AccountCurrencies extends AbstractResult
{
    public ?string $ledgerHash = null;
    public int $ledgerIndex;
    /** @var string[] $receiveCurrencies */
    public array $receiveCurrencies = [];
    /** @var string[] $sendCurrencies */
    public array $sendCurrencies = [];
    public bool $validated;
}
