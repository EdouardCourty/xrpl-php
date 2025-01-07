<?php

declare(strict_types=1);

namespace XRPL\Model\Account;

use XRPL\Model\AbstractResult;
use XRPL\Model\Account\Nested\NFTObject;

class AccountNFTs extends AbstractResult
{
    public string $account;
    /** @var NFTObject[] $accountNfts */
    public array $accountNfts = [];
    public ?string $ledgerHash = null;
    public ?int $ledgerIndex = null;
    public ?int $ledgerCurrentIndex = null;
    public ?bool $validated = null;
    public ?int $limit = null;
    public mixed $marker = null;
}
