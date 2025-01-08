<?php

declare(strict_types=1);

namespace XRPL\Model\Transaction;

use XRPL\Model\AbstractResult;

class SubmittedTransaction extends AbstractResult
{
    public ?string $engineResult = null;
    public ?int $engineResultCode = null;
    public ?string $engineResultMessage = null;
    public ?string $txBlob = null;
    public array $txJson = [];
    public ?bool $accepted = null;
    public ?int $accountSequenceAvailable = null;
    public ?int $accountSequenceNext = null;
    public ?bool $applied = null;
    public ?bool $broadcast = null;
    public ?bool $kept = null;
    public ?bool $queued = null;
    public ?string $openLedgerCost = null;
    public ?int $validatedLedgerIndex = null;
}
