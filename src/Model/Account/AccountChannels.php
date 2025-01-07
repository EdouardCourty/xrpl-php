<?php

declare(strict_types=1);

namespace XRPL\Model\Account;

use XRPL\Model\AbstractResult;
use XRPL\Model\Account\Nested\Channel;

class AccountChannels extends AbstractResult
{
    public string $account;
    /** @var Channel[] $channels */
    public array $channels = [];
    public ?string $ledgerHash = null;
    public int $ledgerIndex;
    public bool $validated = false;
    public ?int $limit = null;
    public mixed $marker = null;
}
