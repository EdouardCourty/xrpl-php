<?php

declare(strict_types=1);

namespace XRPL\Model\Account;

use Symfony\Component\Serializer\Attribute\Ignore;
use XRPL\Model\AbstractResult;
use XRPL\Model\AbstractTransaction;

class AccountTransactions extends AbstractResult
{
    public string $account;
    public int $ledgerIndexMin;
    public int $ledgerIndexMax;
    public ?int $limit = null;
    public mixed $marker = null;
    public ?bool $validated = null;

    /** @var AbstractTransaction[] $transactions */
    #[Ignore]
    public array $transactions = [];
}
