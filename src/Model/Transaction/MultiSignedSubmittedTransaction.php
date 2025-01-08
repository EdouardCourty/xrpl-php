<?php

declare(strict_types=1);

namespace XRPL\Model\Transaction;

use XRPL\Model\AbstractResult;

class MultiSignedSubmittedTransaction extends AbstractResult
{
    public ?string $engineResult = null;
    public ?int $engineResultCode = null;
    public ?string $engineResultMessage = null;
    public ?string $txBlob = null;
    public array $txJson = [];
}
