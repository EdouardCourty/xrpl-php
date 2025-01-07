<?php

declare(strict_types=1);

namespace XRPL\Model\Ledger\LedgerEntry;

use Symfony\Component\Serializer\Attribute\SerializedName;
use XRPL\Model\Ledger\LedgerEntry\Nested\DisabledValidator;

class NegativeUNL extends AbstractLedgerEntry
{
    /** @var DisabledValidator[] $disabledValidators */
    public array $disabledValidators = [];
    #[SerializedName('PreviousTxnID')]
    public ?string $previousTxnID = null;
    public ?int $previousTxnLgrSeq = null;
    public ?string $validatorToDisable = null;
    public ?string $validatorToReEnable = null;
}
