<?php

declare(strict_types=1);

namespace XRPL\Model\Transaction;

use XRPL\Model\AbstractTransaction;

/**
 * https://xrpl.org/nftokenburn.html
 */
class NFTokenBurn extends AbstractTransaction
{
    public string $nFTokenID;
    public ?string $owner = null;
}
