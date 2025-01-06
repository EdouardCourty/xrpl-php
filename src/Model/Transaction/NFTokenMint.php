<?php

declare(strict_types=1);

namespace XRPL\Model\Transaction;

use XRPL\Model\AbstractTransaction;
use XRPL\Model\Transaction\Nested\CurrencyAmount;

/**
 * https://xrpl.org/nftokenmint.html
 */
class NFTokenMint extends AbstractTransaction
{
    public int $nFTokenTaxon;
    public ?string $issuer = null;
    public ?int $transferFee = null;
    public ?string $uri = null;
    public CurrencyAmount $amount;
    public ?int $expiration = null;
    public ?string $destination = null;
}
