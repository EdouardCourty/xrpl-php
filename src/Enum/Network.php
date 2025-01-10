<?php

declare(strict_types=1);

namespace XRPL\Enum;

/**
 * @author Edouard Courty <edouard.courty2@gmail.com>
 */
enum Network: string
{
    case TESTNET = 'testnet';
    case DEVNET = 'devnet';

    public const string TESTNET_FAUCET_URL = 'https://faucet.altnet.rippletest.net';
    public const string DEVNET_FAUCET_URL = 'https://s.devnet.rippletest.net';

    public function getFaucetUrl(): string
    {
        return match ($this) {
            self::TESTNET => self::TESTNET_FAUCET_URL,
            self::DEVNET => self::DEVNET_FAUCET_URL,
        };
    }
}
