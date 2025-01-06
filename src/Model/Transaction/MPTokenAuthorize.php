<?php

namespace XRPL\Model\Transaction;

use XRPL\Model\AbstractTransaction;

/**
 * @see https://xrpl.org/docs/references/protocol/transactions/types/mptokenauthorize
 */
class MPTokenAuthorize extends AbstractTransaction
{
    public string $account;
    public string $MPTokenInsuranceId;
    public ?string $holder = null;
}
