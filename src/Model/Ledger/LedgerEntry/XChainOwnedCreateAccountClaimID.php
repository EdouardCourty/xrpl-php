<?php

declare(strict_types=1);

namespace XRPL\Model\Ledger\LedgerEntry;

use XRPL\Model\Common\XChainBridge;
use XRPL\Model\Ledger\LedgerEntry\Nested\XChainCreateAccountAttestation;

class XChainOwnedCreateAccountClaimID extends AbstractLedgerEntry
{
    public string $account;
    public string $ledgerIndex;
    public int $XChainAccountCreateCount;
    public XChainBridge $XChainBridge;
    /** @var XChainCreateAccountAttestation[] $XChainCreateAccountAttestations */
    public array $XChainCreateAccountAttestations = [];
}
