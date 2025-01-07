<?php

declare(strict_types=1);

namespace XRPL\Model\Ledger\LedgerEntry;

use XRPL\Model\Common\CurrencyAmount;
use XRPL\Model\Common\XChainBridge;

class Bridge extends AbstractLedgerEntry
{
    public string $account;
    public ?CurrencyAmount $minAccountCreateAmount = null;
    public CurrencyAmount $signatureReward;
    public int $XChainAccountClaimCount;
    public int $XChainAccountCreateCount;
    public XChainBridge $XChainBridge;
    public int $XChainClaimID;
}
