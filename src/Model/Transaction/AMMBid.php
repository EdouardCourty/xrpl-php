<?php

declare(strict_types=1);

namespace XRPL\Model\Transaction;

use XRPL\Model\AbstractTransaction;
use XRPL\Model\Transaction\Nested\AMMPoolAsset;
use XRPL\Model\Transaction\Nested\AuthAccount;
use XRPL\Model\Transaction\Nested\CurrencyAmount;

/**
 * @see https://xrpl.org/ammbid.html
 */
class AMMBid extends AbstractTransaction
{
    public AMMPoolAsset $asset;
    public AMMPoolAsset $asset2;
    public ?CurrencyAmount $bidMin = null;
    public ?CurrencyAmount $bidMax = null;
    /** @var AuthAccount[] $authAccounts */
    public array $authAccounts = [];
}
