<?php

declare(strict_types=1);

namespace XRPL\Model\Transaction;

use Symfony\Component\Serializer\Attribute\SerializedName;
use XRPL\Model\AbstractTransaction;
use XRPL\Model\Transaction\Nested\PriceData;

/**
 * https://xrpl.org/docs/references/protocol/transactions/types/oracleset
 */
class OracleSet extends AbstractTransaction
{
    public string $account;
    public string $oracleDocumentId;
    public ?string $provider = null;
    #[SerializedName('URI')]
    public ?string $uri = null;
    public ?int $lastUpdateTime = null;
    public ?string $assetClass = null;
    /** @var PriceData[] $priceDataSeries */
    public array $priceDataSeries = [];
}
