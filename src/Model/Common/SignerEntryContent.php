<?php

declare(strict_types=1);

namespace XRPL\Model\Common;

class SignerEntryContent
{
    public string $account;
    public int $signerWeight;
    public ?string $walletLocator = null;
}
