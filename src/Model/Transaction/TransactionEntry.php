<?php

declare(strict_types=1);

namespace XRPL\Model\Transaction;

use Symfony\Component\Serializer\Attribute\SerializedPath;
use XRPL\Model\AbstractResult;
use XRPL\Model\AbstractTransaction;

class TransactionEntry extends AbstractResult
{
    public ?string $closeTimeIso = null;
    public ?string $hash = null;
    public int $ledgerIndex;
    public ?string $ledgerHash = null;
    public TransactionMetadata $metadata;
    public ?bool $validated = null;
    #[SerializedPath('[tx_json]')]
    public ?AbstractTransaction $transaction = null;
}
