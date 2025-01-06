<?php

declare(strict_types=1);

namespace XRPL\Model;

use XRPL\Model\Transaction\Memo;

abstract class AbstractTransaction
{
    public string $account;
    public string $transactionType;
    public string $fee;
    public int $sequence;
    public ?string $accountTxnID = null;
    public ?int $flags = null;
    public ?int $lastLedgerSequence = null;
    /** @var Memo[] $memos */
    public array $memos = [];
    public ?int $networkId = null;
    public array $signers = [];
    public ?int $sourceTag = null;
    public string $signingPubKey;
    public ?int $ticketSequence = null;
    public string $txnSignature;
}
