<?php

declare(strict_types=1);

namespace XRPL\Model\Ledger\LedgerEntry;

use Symfony\Component\Serializer\Attribute\SerializedName;

class AccountRoot extends AbstractLedgerEntry
{
    public string $account;
    #[SerializedName('AccountTxnID')]
    public ?string $accountTxnID = null;
    #[SerializedName('AMMID')]
    public ?string $AMMID = null;
    public ?string $balance = null;
    #[SerializedName('BurnedNFTokens')]
    public ?int $burnedNFTokens = null;
    public ?string $domain = null;
    public ?string $emailHash = null;
    #[SerializedName('FirstNFTokenSequence')]
    public ?int $firstNFTokenSequence = null;
    public ?string $messageKey = null;
    #[SerializedName('MintedNFTokens')]
    public ?int $mintedNFTokens = null;
    #[SerializedName('NFTokensMinter')]
    public ?int $NFTokenMinter = null;
    public int $ownerCount;
    #[SerializedName('PreviousTxnID')]
    public string $previousTxnID;
    public string $previousTxnLgrSeq;
    public ?string $regularKey = null;
    public int $sequence;
    public ?int $ticketCount = null;
    public ?int $tickSize = null;
    public ?int $transferRate = null;
    public ?string $walletLocator = null;
    public ?int $walletSize = null;
}
