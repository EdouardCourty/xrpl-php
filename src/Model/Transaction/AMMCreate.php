<?php

declare(strict_types=1);

namespace XRPL\Model\Transaction;

use XRPL\Model\AbstractTransaction;
use XRPL\Model\Transaction\Nested\AMMPoolAsset;
use XRPL\Model\Transaction\Nested\AuthAccount;
use XRPL\Model\Transaction\Nested\CurrencyAmount;

/**
 * @see https://xrpl.org/ammcreate.html
 */
class AMMCreate extends AbstractTransaction
{
    public CurrencyAmount $asset;
    public CurrencyAmount $asset2;
    public int $tradingFee;
}
