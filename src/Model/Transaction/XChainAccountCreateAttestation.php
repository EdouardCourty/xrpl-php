<?php

declare(strict_types=1);

namespace XRPL\Model\Transaction;

use XRPL\Model\AbstractTransaction;
use XRPL\Model\Common\CurrencyAmount;
use XRPL\Model\Common\XChainBridge;

/**
 * @see https://xrpl.org/docs/references/protocol/transactions/types/xchainaddaccountcreateattestation
 */
class XChainAccountCreateAttestation extends AbstractTransaction
{
    public CurrencyAmount $amount;
    public string $attestationRewardAccount;
    public string $attestationSignerAccount;
    public string $destination;
    public string $otherChainSource;
    public string $publicKey;
    public string $signature;
    public CurrencyAmount $signatureReward;
    public int|bool $wasLockingChainSend; // Could be a boolean but shown as integer on the documentation
    public string $XChainAccountCreateCount;
    public XChainBridge $XChainBridge;
}
