<?php

declare(strict_types=1);

namespace XRPL\Model\Transaction;

class SignerEntry
{
    public string $account;
    public int $signerWeight;
    public ?string $walletLocator = null;
}
