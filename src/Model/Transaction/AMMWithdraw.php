<?php

declare(strict_types=1);

namespace XRPL\Model\Transaction;

use XRPL\Model\AbstractTransaction;
use XRPL\Model\Common\AMMPoolAsset;
use XRPL\Model\Common\CurrencyAmount;

/**
 * @see https://xrpl.org/ammwithdraw.html
 */
class AMMWithdraw extends AbstractTransaction
{
    public AMMPoolAsset $asset;
    public AMMPoolAsset $asset2;
    public ?CurrencyAmount $amount = null;
    public ?CurrencyAmount $amount2 = null;
    public ?CurrencyAmount $EPrice = null;
    public ?CurrencyAmount $LPTokenIn = null;
}
