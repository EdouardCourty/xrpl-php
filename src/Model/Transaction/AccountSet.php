<?php

declare(strict_types=1);

namespace XRPL\Model\Transaction;

use XRPL\Model\AbstractTransaction;

/**
 * https://xrpl.org/accountset.html
 */
class AccountSet extends AbstractTransaction
{
    public ?int $clearFlag = null;
    public ?string $domain = null;
    public ?string $emailHash = null;
    public ?string $messageKey = null;
    public ?int $setFlag = null;
    public ?int $transferRate = null;
    public ?int $tickSize = null;
    public ?string $walletLocator = null;
    public ?int $walletSize = null;
}
