<?php

declare(strict_types=1);

namespace XRPL\Model\Ledger\Nested;

use Symfony\Component\Serializer\Attribute\Ignore;
use XRPL\Model\AbstractTransaction;

/**
 * @author Edouard Courty
 */
class Ledger
{
    public string $accountHash;
    public int $closeFlags;
    public int $closeTime;
    public string $closeTimeHuman;
    public int $closeTimeResolution;
    public string $closeTimeIso;
    public string $ledgerHash;
    public int $parentLedgerTime;
    public string $parentHash;
    public string $totalCoins;
    public string $transactionHash;
    public string $ledgerIndex;
    public bool $closed;

    /** @var string[] $transactionIds */
    #[Ignore]
    public array $transactionIds = [];

    /** @var array<\XRPL\Model\Transaction\AMMBid|\XRPL\Model\Transaction\AMMCreate|\XRPL\Model\Transaction\AMMDelete|\XRPL\Model\Transaction\AMMDeposit|\XRPL\Model\Transaction\AMMVote|\XRPL\Model\Transaction\AMMWithdraw|\XRPL\Model\Transaction\AccountDelete|\XRPL\Model\Transaction\AccountSet|\XRPL\Model\Transaction\BaseTransaction|\XRPL\Model\Transaction\CheckCancel|\XRPL\Model\Transaction\CheckCash|\XRPL\Model\Transaction\CheckCreate|\XRPL\Model\Transaction\Clawback|\XRPL\Model\Transaction\DIDDelete|\XRPL\Model\Transaction\DIDSet|\XRPL\Model\Transaction\DepositPreauth|\XRPL\Model\Transaction\EscrowCancel|\XRPL\Model\Transaction\EscrowCreate|\XRPL\Model\Transaction\EscrowFinish|\XRPL\Model\Transaction\MPTokenAuthorize|\XRPL\Model\Transaction\MPTokenInsuranceCreate|\XRPL\Model\Transaction\MPTokenInsuranceDestroy|\XRPL\Model\Transaction\MPTokenInsuranceSet|\XRPL\Model\Transaction\NFTokenAcceptOffer|\XRPL\Model\Transaction\NFTokenCancelOffer|\XRPL\Model\Transaction\NFTokenCreateOffer|\XRPL\Model\Transaction\NFTokenMint|\XRPL\Model\Transaction\NFTokenBurn|\XRPL\Model\Transaction\OfferCancel|\XRPL\Model\Transaction\OfferCreate|\XRPL\Model\Transaction\OracleDelete|\XRPL\Model\Transaction\OracleSet|\XRPL\Model\Transaction\Payment|\XRPL\Model\Transaction\PaymentChannelClaim|\XRPL\Model\Transaction\PaymentChannelCreate|\XRPL\Model\Transaction\PaymentChannelFund|\XRPL\Model\Transaction\SetRegularKey|\XRPL\Model\Transaction\SignerListSet|\XRPL\Model\Transaction\TicketCreate|\XRPL\Model\Transaction\TrustSet|\XRPL\Model\Transaction\XChainAccountCreateAttestation|\XRPL\Model\Transaction\XChainAccountCreateCommit|\XRPL\Model\Transaction\XChainClaim|\XRPL\Model\Transaction\XChainCommit|\XRPL\Model\Transaction\XChainCreateBridge|\XRPL\Model\Transaction\XChainCreateClaimID|\XRPL\Model\Transaction\XChainModifyBridge> $transactions */
    public array $transactions = [];
}
