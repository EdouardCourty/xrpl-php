<?php

declare(strict_types=1);

namespace XRPL\Model\Transaction;

use XRPL\Model\AbstractTransaction;

/**
 * @see https://xrpl.org/docs/references/protocol/transactions/types/mptokenissuancecreate
 */
class MPTokenInsuranceCreate extends AbstractTransaction
{
    public ?int $assetScale = null;
    public ?int $transferFee = null;
    public ?string $maximumAmount = null;
    public ?string $MPTokenMetadata = null;
}
