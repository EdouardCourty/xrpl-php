<?php

declare(strict_types=1);

namespace XRPL\ValueObject;

use XRPL\Enum\Network;
use XRPL\Service\Faucet;
use XRPL\Service\Wallet\WalletGenerator;

/**
 * @author Edouard Courty <edouard.courty2@gmail.com>
 */
readonly class Wallet
{
    public const string ALGORITHM_ED25519 = 'ed25519';
    public const string ALGORITHM_SECP256K1 = 'secp256k1';

    public const array ALGORITHMS = [
        self::ALGORITHM_ED25519,
        self::ALGORITHM_SECP256K1,
    ];

    public function __construct(
        #[\SensitiveParameter]
        public Seed $seed,
        #[\SensitiveParameter]
        public KeyPair $keyPair,
        public string $address,
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

    public static function generate(string $algorithm = self::ALGORITHM_ED25519): self
    {
        return WalletGenerator::generate($algorithm);
    }

    public static function generateFromSeed(#[\SensitiveParameter] string $seed): self
    {
        return WalletGenerator::generateFromSeed($seed);
    }
}
