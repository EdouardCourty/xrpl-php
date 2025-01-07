<?php

declare(strict_types=1);

namespace XRPL\Model\Account;

use XRPL\Model\AbstractResult;
use XRPL\Model\Ledger\LedgerEntry\AbstractLedgerEntry;

class AccountObjects extends AbstractResult
{
    public string $account;
    /** @var AbstractLedgerEntry[] $accountObjects */
    public array $accountObjects = [];
    public ?string $ledgerHash = null;
    public ?int $ledgerIndex = null;
    public ?int $ledgerCurrentIndex = null;
    public ?int $limit = null;
    public mixed $marker = null;
    public ?bool $validated = null;
}
