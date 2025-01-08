<?php

declare(strict_types=1);

namespace XRPL\Model\Payment;

use XRPL\Model\AbstractResult;
use XRPL\Model\Payment\Nested\AMMDescription;

class AMMInfo extends AbstractResult
{
    public AMMDescription $amm;
    public int|string|null $ledgerIndex = null;
    public int|string|null $ledgerCurrentIndex = null;
    public ?string $ledgerHash = null;
    public ?bool $validated = null;
}
