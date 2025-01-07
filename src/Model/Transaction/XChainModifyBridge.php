<?php

declare(strict_types=1);

namespace XRPL\Model\Transaction;

use XRPL\Model\AbstractTransaction;
use XRPL\Model\Common\CurrencyAmount;
use XRPL\Model\Common\XChainBridge;

/**
 * @see https://xrpl.org/docs/references/protocol/transactions/types/xchainmodifybridge
 */
class XChainModifyBridge extends AbstractTransaction
{
    public ?CurrencyAmount $minAccountCreateAmount = null;
    public ?CurrencyAmount $signatureReward = null;
    public XChainBridge $XChainBridge;
}
