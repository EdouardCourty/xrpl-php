<?php

declare(strict_types=1);

namespace XRPL\Tests\Support;

use XRPL\Contract\WalletInterface;
use XRPL\Enum\Algorithm;

/**
 * @author Edouard Courty
 */
class ExternalWallet implements WalletInterface
{
    public function getPublicKey(): string
    {
        return 'ED5BA43AC2ADF97D8CF8EA7F61B6F183020C5C7AC3F2BD9D318A747D7956B9D841';
    }

    public function getPrivateKey(): string
    {
        return 'EDAE87E94B5AE54E5C7ABE29989E9410C2890D49209CF130368F054441C2AC0A73';
    }

    public function getAddress(): string
    {
        return 'rhs9ZU3RCaMWiSCfxeu3X3v6zG1iNniG1S';
    }

    public function getAlgorithm(): Algorithm
    {
        return Algorithm::ED25519;
    }
}
