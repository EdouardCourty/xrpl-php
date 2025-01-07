<?php

declare(strict_types=1);

namespace XRPL\Model\Transaction;

use XRPL\Model\AbstractTransaction;
use XRPL\Model\Common\CurrencyAmount;
use XRPL\Model\Common\XChainBridge;

class XChainAccountCreateCommit extends AbstractTransaction
{
    public CurrencyAmount $amount;
    public string $destination;
    public ?CurrencyAmount $signatureReward = null;
    public XChainBridge $XChainBridge;
}
