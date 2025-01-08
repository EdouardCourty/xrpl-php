<?php

declare(strict_types=1);

namespace XRPL\Model\Transaction;

use Symfony\Component\Serializer\Attribute\SerializedName;
use XRPL\Model\Common\CurrencyAmount;

class TransactionMetadata
{
    #[SerializedName('AffectedNodes')]
    public array $affectedNodes = [];
    #[SerializedName('TransactionIndex')]
    public int $transactionIndex;
    #[SerializedName('TransactionResult')]
    public string $transactionResult;
    public CurrencyAmount $deliveredAmount;
}
