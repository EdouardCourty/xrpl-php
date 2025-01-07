<?php

declare(strict_types=1);

namespace XRPL\Model\Ledger\LedgerEntry;

use Symfony\Component\Serializer\Attribute\SerializedName;
use XRPL\Model\Ledger\LedgerEntry\Nested\NFToken;

class NFTokenPage extends AbstractLedgerEntry
{
    public ?string $nextPageMin = null;
    /** @var NFToken[] $NFTokens */
    public array $NFTokens = [];
    public ?string $previousPageMin = null;
    #[SerializedName('PreviousTxnID')]
    public ?string $previousTxnID = null;
    public ?int $previousTxnLgrSeq = null;
}
