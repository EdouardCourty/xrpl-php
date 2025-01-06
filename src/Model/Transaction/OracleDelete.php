<?php

declare(strict_types=1);

namespace XRPL\Model\Transaction;

use XRPL\Model\AbstractTransaction;
use XRPL\Model\Transaction\Nested\CurrencyAmount;

/**
 * https://xrpl.org/docs/references/protocol/transactions/types/oracledelete
 */
class OracleDelete extends AbstractTransaction
{
    public string $account;
    public string $oracleDocumentId;
}
