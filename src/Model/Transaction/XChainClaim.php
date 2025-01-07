<?php

declare(strict_types=1);

namespace XRPL\Model\Transaction;

use XRPL\Model\AbstractTransaction;
use XRPL\Model\Common\CurrencyAmount;
use XRPL\Model\Common\XChainBridge;

/**
 * @see https://xrpl.org/docs/references/protocol/transactions/types/xchainclaim
 */
class XChainClaim extends AbstractTransaction
{
    public CurrencyAmount $amount;
    public string $destination;
    public ?string $destinationTag = null;
    public XChainBridge $XChainBridge;
    public string $XChainClaimId;
}
