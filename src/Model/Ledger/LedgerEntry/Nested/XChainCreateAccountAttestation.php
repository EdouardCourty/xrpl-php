<?php

declare(strict_types=1);

namespace XRPL\Model\Ledger\LedgerEntry\Nested;

use XRPL\Model\Common\CurrencyAmount;

class XChainCreateAccountAttestation
{
    public array $XChainCreateAccountProofSig = [];
    public CurrencyAmount $amount;
    public string $attestationRewardAccount;
    public string $attestationSignerAccount;
    public string $destination;
    public string $publicKey;
    public int $wasLockingChainSend;
}
