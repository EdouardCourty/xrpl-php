<?php

declare(strict_types=1);

namespace XRPL\Model\Account;

use XRPL\Model\AbstractResult;
use XRPL\Model\Account\Nested\TrustLine;

class AccountLines extends AbstractResult
{
    public string $account;
    /** @var TrustLine[] $lines */
    public array $lines = [];
    public ?int $ledgerCurrentIndex = null;
    public ?int $ledgerIndex = null;
    public ?string $ledgerHash = null;
    public ?int $limit = null;
    public mixed $marker = null;
    public ?bool $validated = null;
}
