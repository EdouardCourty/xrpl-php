<?php

declare(strict_types=1);

namespace XRPL\Model\Account;

use XRPL\Model\AbstractResult;

class AccountObjects extends AbstractResult
{
    public string $account;
    /** @var array<\XRPL\Model\Ledger\LedgerEntry\AMM|\XRPL\Model\Ledger\LedgerEntry\AccountRoot|\XRPL\Model\Ledger\LedgerEntry\Amendements|\XRPL\Model\Ledger\LedgerEntry\BaseLedgerEntry|\XRPL\Model\Ledger\LedgerEntry\Bridge|\XRPL\Model\Ledger\LedgerEntry\Check|\XRPL\Model\Ledger\LedgerEntry\DID|\XRPL\Model\Ledger\LedgerEntry\DepositPreauth|\XRPL\Model\Ledger\LedgerEntry\DirectoryNode|\XRPL\Model\Ledger\LedgerEntry\Escrow|\XRPL\Model\Ledger\LedgerEntry\FeeSettings|\XRPL\Model\Ledger\LedgerEntry\LedgerHashes|\XRPL\Model\Ledger\LedgerEntry\MPToken|\XRPL\Model\Ledger\LedgerEntry\MPTokenIssuance|\XRPL\Model\Ledger\LedgerEntry\NFTokenOffer|\XRPL\Model\Ledger\LedgerEntry\NFTokenPage|\XRPL\Model\Ledger\LedgerEntry\NegativeUNL|\XRPL\Model\Ledger\LedgerEntry\Offer|\XRPL\Model\Ledger\LedgerEntry\Oracle|\XRPL\Model\Ledger\LedgerEntry\PayChannel|\XRPL\Model\Ledger\LedgerEntry\RippleState|\XRPL\Model\Ledger\LedgerEntry\SignerList|\XRPL\Model\Ledger\LedgerEntry\Ticket|\XRPL\Model\Ledger\LedgerEntry\XChainOwnedCreateAccountClaimID|\XRPL\Model\Ledger\LedgerEntry\XChainOwnerClaimID> $accountObjects */
    public array $accountObjects = [];
    public ?string $ledgerHash = null;
    public ?int $ledgerIndex = null;
    public ?int $ledgerCurrentIndex = null;
    public ?int $limit = null;
    public mixed $marker = null;
    public ?bool $validated = null;
}
