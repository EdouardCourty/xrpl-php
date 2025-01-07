<?php

declare(strict_types=1);

namespace XRPL\Model\Account\Nested;

use XRPL\Model\Common\CurrencyAmount;

class Offer
{
    public int $flags;
    public int $seq;
    public CurrencyAmount $takerGets;
    public CurrencyAmount $takerPays;
    public string $quality;
    public int $expiration;
}
