<?php

declare(strict_types=1);

namespace XRPL\Service;

use Symfony\Component\HttpClient\HttpClient;
use XRPL\Contract\WalletInterface;
use XRPL\Enum\Network;

/**
 * @author Edouard Courty
 */
class Faucet
{
    /**
     * Will add 100 XRP to the wallet.
     */
    public static function addFunds(WalletInterface|string $walletOrAddress, Network $network = Network::TESTNET): void
    {
        $address = \is_string($walletOrAddress) ? $walletOrAddress : $walletOrAddress->getAddress();

        $httpClient = HttpClient::createForBaseUri($network->getFaucetUrl());
        $response = $httpClient->request('POST', '/accounts', [
            'json' => [
                'destination' => $address,
                'userAgent' => 'ecourty/xrpl-php',
            ],
        ]);

        if ($response->getStatusCode() !== 200) {
            throw new \RuntimeException('Failed to add funds to the wallet.');
        }
    }
}
