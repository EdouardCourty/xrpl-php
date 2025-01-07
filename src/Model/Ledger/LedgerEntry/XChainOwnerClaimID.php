<?php

declare(strict_types=1);

namespace XRPL\Model\Ledger\LedgerEntry;

use XRPL\Model\Common\CurrencyAmount;
use XRPL\Model\Common\XChainBridge;

class XChainOwnerClaimID extends AbstractLedgerEntry
{
    public string $account;
    public string $ledgerIndex;
    public string $otherChainSource;
    public CurrencyAmount $signatureReward;
    public XChainBridge $XChainBridge;
    public array $XChainClaimAttestations = [];
    public string $XChainClaimID;
}
