<?php

declare(strict_types=1);

namespace XRPL\Model\Transaction;

use Symfony\Component\Serializer\Attribute\SerializedName;
use XRPL\Model\AbstractTransaction;
use XRPL\Model\Common\CurrencyAmount;

/**
 * https://xrpl.org/nftokenmint.html
 */
class NFTokenMint extends AbstractTransaction
{
    #[SerializedName('NFTokenTaxon')]
    public int $NFTokenTaxon;
    public ?string $issuer = null;
    public ?int $transferFee = null;
    #[SerializedName('URI')]
    public ?string $uri = null;
    public CurrencyAmount $amount;
    public ?int $expiration = null;
    public ?string $destination = null;
}
