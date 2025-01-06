<?php

declare(strict_types=1);

namespace XRPL\Model\Transaction;

use XRPL\Model\AbstractTransaction;
use XRPL\Model\Transaction\Nested\CurrencyAmount;
use XRPL\Model\Transaction\Nested\XChainBridge;

/**
 * @see https://xrpl.org/docs/references/protocol/transactions/types/xchaincommit
 */
class XChainCommit extends AbstractTransaction
{
    public CurrencyAmount $amount;
    public ?string $otherChainDestination = null;
    public XChainBridge $XChainBridge;
    public string $XChainClaimId;
}
