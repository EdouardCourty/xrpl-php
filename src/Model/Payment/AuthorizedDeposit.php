<?php

declare(strict_types=1);

namespace XRPL\Model\Payment;

use XRPL\Model\AbstractResult;

class AuthorizedDeposit extends AbstractResult
{
    public bool $depositAuthorized;
    public string $destinationAccount;
    public string $ledgerHash;
    public int|string|null $ledgerIndex = null;
    public int|string|null $ledgerCurrentIndex = null;
    public string $sourceAccount;
    public ?bool $validated = null;
}
