<?php

declare(strict_types=1);

namespace XRPL\Model\Transaction;

use XRPL\Model\AbstractTransaction;
use XRPL\Model\Common\AMMPoolAsset;

/**
 * @see https://xrpl.org/ammvote.html
 */
class AMMVote extends AbstractTransaction
{
    public AMMPoolAsset $asset;
    public AMMPoolAsset $asset2;
    public ?int $tradingFee = null;
}
