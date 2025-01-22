<?php

require_once __DIR__ . '/../vendor/autoload.php';

use XRPL\ValueObject\Wallet;

// ======= GENERATE A WALLET FROM AN EXISTING SEED =======

$seed = 'sEdSgVhT1uGZErffGfLHX61ZkjAtPg2'; // A valid seed
$wallet = Wallet::generateFromSeed($seed);

echo 'Wallet address: ' . $wallet->getAddress() . PHP_EOL;
echo 'Wallet Public Key: ' . $wallet->getPublicKey() . PHP_EOL;
echo 'Wallet Private Key: ' . $wallet->getSeedString() . PHP_EOL;

// ======= GENERATE A WALLET FROM SCRATCH =======

$wallet = Wallet::generate();

echo 'Wallet address: ' . $wallet->getAddress() . PHP_EOL;
echo 'Wallet Public Key: ' . $wallet->getPublicKey() . PHP_EOL;
echo 'Wallet Private Key: ' . $wallet->getSeedString() . PHP_EOL;
