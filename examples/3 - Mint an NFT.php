<?php

require_once __DIR__ . '/../vendor/autoload.php';

use XRPL\Client\XRPLClient;
use XRPL\Service\Faucet;
use XRPL\ValueObject\Wallet;

/**
 * @see https://xrpl.org/docs/references/protocol/transactions/types/nftokenmint
 */

$wallet = Wallet::generate(); // You can also import an existing wallet (See 1 - Manage wallets.php)
Faucet::addFunds($wallet);

echo 'Wallet generated and funded!' . PHP_EOL;

$client = new XRPLClient('https://s.altnet.rippletest.net:51234');

$transactionData = [
    'TransactionType' => 'NFTokenMint',
    'Account' => $wallet->getAddress(),
    'URI' => '11223344', // Can be virtually anything (Needs to be a hex string)
    'Flags' => 8, // Makes the NFT transferable
    'TransferFee' => 1000, // Fee for transferring the NFT
    'NFTokenTaxon' => 0, // Allows for grouping of NFTs (e.g. by collection, use the same taxon for NFTs of the same collection)
];

$client->submitSingleSignTransaction($transactionData, $wallet);

echo 'NFT minted!' . PHP_EOL;
