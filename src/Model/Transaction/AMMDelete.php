<?php

declare(strict_types=1);

namespace XRPL\Model\Transaction;

use XRPL\Model\AbstractTransaction;
use XRPL\Model\Common\AMMPoolAsset;

/**
 * @see https://xrpl.org/ammdelete.html
 */
class AMMDelete extends AbstractTransaction
{
    public AMMPoolAsset $asset;
    public AMMPoolAsset $asset2;
}
