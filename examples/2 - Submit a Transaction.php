<?php

require_once __DIR__ . '/../vendor/autoload.php';

use XRPL\Client\XRPLClient;
use XRPL\Helper\XRPConverter;
use XRPL\Service\Faucet;
use XRPL\ValueObject\Wallet;

$originWallet = Wallet::generate();
$receiverWallet = Wallet::generate();

echo 'Origin wallet address: ' . $originWallet->getAddress() . PHP_EOL;
echo 'Receiver wallet address: ' . $receiverWallet->getAddress() . PHP_EOL;

Faucet::addFunds($originWallet); // Adds 100 XRP to the origin wallet

echo 'Added 100 XRP to the origin wallet' . PHP_EOL;

$client = new XRPLClient('https://s.altnet.rippletest.net:51234'); // Public Testnet Ripple Node

$transactionData = [
    'TransactionType' => 'Payment',
    'Account' => $originWallet->getAddress(),
    'Destination' => $receiverWallet->getAddress(),
    'Amount' => XRPConverter::xrpToDrops(25), // 25 XRP
];

$client->submitSingleSignTransaction($transactionData, $originWallet);

echo 'Transaction submitted';
