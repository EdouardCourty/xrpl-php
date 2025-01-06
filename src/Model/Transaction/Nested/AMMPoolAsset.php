<?php

declare(strict_types=1);

namespace XRPL\Model\Transaction\Nested;

/**
 * @see https://xrpl.org/ammbid.html
 */
class AMMPoolAsset
{
    public string $currency;
    public ?string $issuer = null;
}
