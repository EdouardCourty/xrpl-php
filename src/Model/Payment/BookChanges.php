<?php

declare(strict_types=1);

namespace XRPL\Model\Payment;

use XRPL\Model\AbstractResult;
use XRPL\Model\Payment\Nested\BookUpdate;

class BookChanges extends AbstractResult
{
    /** @var BookUpdate[] $changes */
    public array $changes = [];
    public string $ledgerHash;
    public string|int $ledgerIndex;
    public int $ledgerTime;
    public string $type;
    public ?bool $validated = null;
}
