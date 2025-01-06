<?php

declare(strict_types=1);

namespace XRPL\Model\Transaction;

use XRPL\Model\AbstractTransaction;
use XRPL\Model\Transaction\Nested\AMMPoolAsset;
use XRPL\Model\Transaction\Nested\AuthAccount;
use XRPL\Model\Transaction\Nested\CurrencyAmount;

/**
 * @see https://xrpl.org/ammdeposit.html
 */
class AMMDeposit extends AbstractTransaction
{
    public AMMPoolAsset $asset;
    public AMMPoolAsset $asset2;
    public ?CurrencyAmount $amount = null;
    public ?CurrencyAmount $amount2 = null;
    public ?CurrencyAmount $EPrice = null;
    public ?CurrencyAmount $LPTokenOut = null;
    public ?int $tradingFee = null;
}
