<?php

namespace XRPL\Model\Transaction;

use XRPL\Model\AbstractTransaction;

/**
 * @see https://xrpl.org/docs/references/protocol/transactions/types/mptokenissuanceset
 */
class MPTokenInsuranceSet extends AbstractTransaction
{
    public string $MPTokenInsuranceId;
    public string $holder;
    public int $flag; // Not sure if this is right, but it is in the docs
}
