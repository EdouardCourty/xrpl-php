<?php

declare(strict_types=1);

namespace XRPL\Model\Transaction;

use XRPL\Model\AbstractTransaction;

/**
 * https://xrpl.org/docs/references/protocol/transactions/types/oracledelete
 */
class OracleDelete extends AbstractTransaction
{
    public string $account;
    public string $oracleDocumentId;
}
