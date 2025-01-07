<?php

declare(strict_types=1);

namespace XRPL\Model\Transaction;

use XRPL\Model\AbstractTransaction;

/**
 * @see https://xrpl.org/docs/references/protocol/transactions/types/mptokenissuancedestroy
 */
class MPTokenInsuranceDestroy extends AbstractTransaction
{
    public string $MPTokenInsuranceId;
}
