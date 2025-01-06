<?php

declare(strict_types=1);

namespace XRPL\Model\Transaction\Nested;

/**
 * @see https://xrpl.org/docs/references/protocol/transactions/types/oracleset
 */
class PriceData
{
    public string $baseAsset;
    public string $quoteAsset;
    public ?string $assetPrice = null;
    public ?int $scale = null;
}
