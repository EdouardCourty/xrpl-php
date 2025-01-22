<?php

declare(strict_types=1);

namespace XRPL\ValueObject;

use XRPL\Contract\KeyPairInterface;
use XRPL\Contract\WalletInterface;
use XRPL\Enum\Algorithm;
use XRPL\Enum\Network;
use XRPL\Service\Faucet;
use XRPL\Service\TransactionEncoder;
use XRPL\Service\Wallet\WalletGenerator;

/**
 * @author Edouard Courty
 */
readonly class Wallet implements WalletInterface
{
    public function __construct(
        #[\SensitiveParameter]
        public Seed $seed,
        #[\SensitiveParameter]
        public KeyPairInterface $keyPair,
        private string $address,
    ) {
    }

    public function getSeedString(): string
    {
        return $this->seed->toString();
    }

    /**
     * Adds 100 XRP to this wallet on the specified network (default is testnet).
     */
    public function addFunds(Network $network = Network::TESTNET): void
    {
        Faucet::addFunds($this, $network);
    }

    public static function generate(Algorithm $algorithm = Algorithm::ED25519): WalletInterface
    {
        return WalletGenerator::generate($algorithm);
    }

    public static function generateFromSeed(#[\SensitiveParameter] string $seed): WalletInterface
    {
        return WalletGenerator::generateFromSeed($seed);
    }

    public function getPublicKey(): string
    {
        return $this->keyPair->getPublicKey();
    }

    public function getPrivateKey(): string
    {
        return $this->keyPair->getPrivateKey();
    }

    public function sign(array $transactionData): string
    {
        return TransactionEncoder::encodeForSingleSign($transactionData, $this);
    }

    public function multiSign(array $transactionData): string
    {
        return TransactionEncoder::encodeForMultiSign($transactionData, $this);
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getAlgorithm(): Algorithm
    {
        return $this->seed->algorithm;
    }
}
