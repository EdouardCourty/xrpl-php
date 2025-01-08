<?php

declare(strict_types=1);

namespace XRPL\Model\Account;

use XRPL\Model\AbstractResult;
use XRPL\Model\AbstractTransaction;

class NoRippleCheck extends AbstractResult
{
    public const string ROLE_GATEWAY = 'gateway';
    public const string ROLE_USER = 'user';

    public int $ledgerCurrentIndex;
    /** @var string[] $problems */
    public array $problems = [];
    /** @var AbstractTransaction[] $transactions */
    public array $transactions = [];
}
