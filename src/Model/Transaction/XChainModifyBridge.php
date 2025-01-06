<?php

declare(strict_types=1);

namespace XRPL\Model\Transaction;

use XRPL\Model\AbstractTransaction;
use XRPL\Model\Transaction\Nested\CurrencyAmount;
use XRPL\Model\Transaction\Nested\XChainBridge;

/**
 * @see https://xrpl.org/docs/references/protocol/transactions/types/xchainmodifybridge
 */
class XChainModifyBridge extends AbstractTransaction
{
    public ?CurrencyAmount $minAccountCreateAmount = null;
    public ?CurrencyAmount $signatureReward = null;
    public XChainBridge $XChainBridge;
}
