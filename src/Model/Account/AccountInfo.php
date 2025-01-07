<?php

declare(strict_types=1);

namespace XRPL\Model\Account;

use XRPL\Model\AbstractResult;
use XRPL\Model\Account\Nested\AccountFlags;
use XRPL\Model\Account\Nested\AccountRoot;
use XRPL\Model\Account\Nested\QueueData;

class AccountInfo extends AbstractResult
{
    public AccountRoot $accountData;
    public AccountFlags $accountFlags;
    public array $signerLists = [];
    public ?int $ledgerCurrentIndex = null;
    public ?int $ledgerIndex = null;
    public ?QueueData $queueData = null;
    public bool $validated = false;
}
