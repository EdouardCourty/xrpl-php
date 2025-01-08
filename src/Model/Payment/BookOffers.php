<?php

declare(strict_types=1);

namespace XRPL\Model\Payment;

use XRPL\Model\AbstractResult;
use XRPL\Model\Payment\Nested\Offer;

class BookOffers extends AbstractResult
{
    public string|int|null $ledgerCurrentIndex = null;
    public string|int|null $ledgerIndex = null;
    public ?string $ledgerHash = null;
    /** @var Offer[] $offers */
    public array $offers = [];
}
