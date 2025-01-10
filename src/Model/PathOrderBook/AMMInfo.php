<?php

declare(strict_types=1);

namespace XRPL\Model\PathOrderBook;

use XRPL\Model\AbstractResult;
use XRPL\Model\PathOrderBook\Nested\AMMDescription;

class AMMInfo extends AbstractResult
{
    public AMMDescription $amm;
    public int|string|null $ledgerIndex = null;
    public int|string|null $ledgerCurrentIndex = null;
    public ?string $ledgerHash = null;
    public ?bool $validated = null;
}
