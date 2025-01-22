<?php

declare(strict_types=1);

namespace XRPL\Contract;

use XRPL\Enum\Algorithm;
use XRPL\ValueObject\Wallet;

/**
 * @author Edouard Courty
 *
 * A Wallet must contain its keypair, address and signature algorithm.
 *
 * @see Wallet for a simple implementation. You can build your own if the provided one is not sufficient.
 */
interface WalletInterface
{
    public function getPublicKey(): string;
    public function getPrivateKey(): string;

    public function getAddress(): string;

    public function getAlgorithm(): Algorithm;
}
