<?php

declare(strict_types=1);

namespace XRPL\Model\Account;

use XRPL\Model\AbstractResult;
use XRPL\Model\Account\Nested\AccountTransaction;

class AccountTransactions extends AbstractResult
{
    public string $account;
    public int $ledgerIndexMin;
    public int $ledgerIndexMax;
    public ?int $limit = null;
    public mixed $marker = null;
    public ?bool $validated = null;
    /** @var AccountTransaction[] $transactions */
    public array $transactions = [];
}
