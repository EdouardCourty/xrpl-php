<?php

declare(strict_types=1);

namespace XRPL\Model\Ledger\LedgerEntry;

use Symfony\Component\Serializer\Attribute\SerializedName;
use XRPL\Model\Common\SignerEntry;

class SignerList extends AbstractLedgerEntry
{
    public string $ownerNode;
    #[SerializedName('PreviousTxnID')]
    public string $previousTxnID;
    public int $previousTxnLgrSeq;
    /** @var SignerEntry[] $signerEntries */
    public array $signerEntries = [];
    public int $signerListId;
    public int $signerQuorum;
}
