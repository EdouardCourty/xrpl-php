<?php

declare(strict_types=1);

namespace XRPL\Model\Ledger\LedgerEntry;

use Symfony\Component\Serializer\Attribute\SerializedName;
use XRPL\Model\Ledger\LedgerEntry\Nested\Majority;

class Amendements extends AbstractLedgerEntry
{
    /** @var string[] $amendements */
    public array $amendements = [];
    /** @var Majority[] $majorities */
    public array $majorities = [];
    #[SerializedName('PreviousTxnID')]
    public ?string $previousTxnID = null;
    public ?int $previousTxnLgrSeq = null;
}
