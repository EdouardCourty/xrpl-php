<?php

declare(strict_types=1);

namespace XRPL\Model\PathOrderBook;

use XRPL\Model\AbstractResult;
use XRPL\Model\PathOrderBook\Nested\BookUpdate;

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
