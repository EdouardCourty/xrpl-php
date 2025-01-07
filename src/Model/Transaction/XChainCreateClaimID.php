<?php

declare(strict_types=1);

namespace XRPL\Model\Transaction;

use XRPL\Model\AbstractTransaction;
use XRPL\Model\Common\CurrencyAmount;
use XRPL\Model\Common\XChainBridge;

/**
 * @see https://xrpl.org/docs/references/protocol/transactions/types/xchaincreatebridge
 */
class XChainCreateClaimID extends AbstractTransaction
{
    public string $otherChainSource;
    public CurrencyAmount $signatureReward;
    public XChainBridge $XChainBridge;
}
