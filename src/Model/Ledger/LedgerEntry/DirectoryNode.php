<?php

declare(strict_types=1);

namespace XRPL\Model\Ledger\LedgerEntry;

use Symfony\Component\Serializer\Attribute\SerializedName;

class DirectoryNode extends AbstractLedgerEntry
{
    public array $indexes = [];
    public ?int $indexNext = null;
    public ?int $indexPrevious = null;
    public ?string $NFTokenId = null;
    public ?string $owner = null;
    #[SerializedName('PreviousTxnID')]
    public ?string $previousTxnID = null;
    public ?int $previousTxnLgrSeq = null;
    public string $rootIndex;
    public ?string $takerGetsCurrency = null;
    public ?string $takerGetsIssuer = null;
    public ?string $takerPaysCurrency = null;
    public ?string $takerPaysIssuer = null;
}
