<?php

declare(strict_types=1);

namespace XRPL\Enum;

use XRPL\Model\Transaction\BaseTransaction;

/**
 * @author Edouard Courty <edouard.courty2@gmail.com>
 */
enum TransactionTypeEnum: string
{
    case AccountSet = 'AccountSet';
    case AccountDelete = 'AccountDelete';
    case AMMBid = 'AMMBid';
    case AMMCreate = 'AMMCreate';
    case AMMDelete = 'AMMDelete';
    case AMMDeposit = 'AMMDeposit';
    case AMMVote = 'AMMVote';
    case AMMWithdraw = 'AMMWithdraw';
    case CheckCancel = 'CheckCancel';
    case CheckCash = 'CheckCash';
    case CheckCreate = 'CheckCreate';
    case Clawback = 'Clawback';
    case DepositPreauth = 'DepositPreauth';
    case DIDDelete = 'DIDDelete';
    case DIDSet = 'DIDSet';
    case EscrowCancel = 'EscrowCancel';
    case EscrowCreate = 'EscrowCreate';
    case EscrowFinish = 'EscrowFinish';
    case MPTokenAuthorize = 'MPTokenAuthorize';
    case MPTokenIssuanceCreate = 'MPTokenIssuanceCreate';
    case MPTokenIssuanceDestroy = 'MPTokenIssuanceDestroy';
    case MPTokenIssuanceSet = 'MPTokenIssuanceSet';
    case NFTokenAcceptOffer = 'NFTokenAcceptOffer';
    case NFTokenBurn = 'NFTokenBurn';
    case NFTokenCancelOffer = 'NFTokenCancelOffer';
    case NFTokenCreateOffer = 'NFTokenCreateOffer';
    case NFTokenMint = 'NFTokenMint';
    case OfferCancel = 'OfferCancel';
    case OfferCreate = 'OfferCreate';
    case OracleDelete = 'OracleDelete';
    case OracleSet = 'OracleSet';
    case Payment = 'Payment';
    case PaymentChannelClaim = 'PaymentChannelClaim';
    case PaymentChannelCreate = 'PaymentChannelCreate';
    case PaymentChannelFund = 'PaymentChannelFund';
    case SetRegularKey = 'SetRegularKey';
    case SignerListSet = 'SignerListSet';
    case TicketCreate = 'TicketCreate';
    case TrustSet = 'TrustSet';
    case XChainAccountCreateCommit = 'XChainAccountCreateCommit';
    case XChainAddAccountCreateAttestation = 'XChainAddAccountCreateAttestation';
    case XChainAddClaimAttestation = 'XChainAddClaimAttestation';
    case XChainClaim = 'XChainClaim';
    case XChainCommit = 'XChainCommit';
    case XChainCreateBridge = 'XChainCreateBridge';
    case XChainCreateClaimID = 'XChainCreateClaimID';
    case XChainModifyBridge = 'XChainModifyBridge';

    case Unknown = 'Unknown';

    public function getClass(): string
    {
        // For example: "XRPL\Model\Transaction\Payment"
        $candidateClass = __NAMESPACE__ . '\\..\\Model\\Transaction\\' . $this->name;

        // Normalize/slash-fix: __NAMESPACE__ points to "XRPL\Enum",
        // so moving one level up becomes "XRPL", then into "Model\Transaction"
        // E.g., "XRPL\Enum\..\Model\Transaction\Payment"
        // We'll parse/normalize that.
        $candidateClass = str_replace(['\\Enum\\..\\', '\\..\\'], ['\\', '\\'], $candidateClass);

        if (class_exists($candidateClass)) {
            return $candidateClass;
        }

        return BaseTransaction::class;
    }
}
