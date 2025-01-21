<?php

declare(strict_types=1);

namespace XRPL\Enum;

use XRPL\Model\Transaction\BaseTransaction;

/**
 * @author Edouard Courty
 */
enum LedgerEntryTypeEnum: string
{
    case AccountRoot = 'AccountRoot';
    case Amendments = 'Amendments';
    case AMM = 'AMM';
    case Bridge = 'Bridge';
    case Check = 'Check';
    case DepositPreauth = 'DepositPreauth';
    case DID = 'DID';
    case DirectoryNode = 'DirectoryNode';
    case Escrow = 'Escrow';
    case FeeSettings = 'FeeSettings';
    case LedgerHashes = 'LedgerHashes';
    case MPToken = 'MPToken';
    case MPTokenIssuance = 'MPTokenIssuance';
    case NegativeUNL = 'NegativeUNL';
    case NFTokenOffer = 'NFTokenOffer';
    case NFTokenPage = 'NFTokenPage';
    case Offer = 'Offer';
    case Oracle = 'Oracle';
    case PayChannel = 'PayChannel';
    case RippleState = 'RippleState';
    case SignerList = 'SignerList';
    case Ticket = 'Ticket';
    case XChainOwnedClaimID = 'XChainOwnedClaimID';
    case XChainOwnedCreateAccountClaimID = 'XChainOwnedCreateAccountClaimID';

    case Unknown = 'Unknown';

    public function getClass(): string
    {
        // For example: "XRPL\Model\Ledger\LedgerEntry\AccountRoot"
        $candidateClass = __NAMESPACE__ . '\\..\\Model\\Ledger\\LedgerEntry\\' . $this->name;

        // Normalize/slash-fix: __NAMESPACE__ points to "XRPL\Enum",
        // so moving one level up becomes "XRPL", then into "Model\Ledger\LedgerEntry"
        // E.g., "XRPL\Enum\..\Model\Ledger\LedgerEntry\AccountRoot"
        // We'll parse/normalize that.
        $candidateClass = str_replace(['\\Enum\\..\\', '\\..\\'], ['\\', '\\'], $candidateClass);

        if (class_exists($candidateClass)) {
            return $candidateClass;
        }

        return BaseTransaction::class;
    }
}
