<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use XRPL\ValueObject\Wallet;

// ======= GENERATE A WALLET FROM AN EXISTING SEED =======

echo 'Generating a wallet from an existing seed:' . \PHP_EOL . \PHP_EOL;

$seed = 'sEdSgVhT1uGZErffGfLHX61ZkjAtPg2'; // A valid seed
$wallet = Wallet::generateFromSeed($seed);

echo 'Wallet address: ' . $wallet->getAddress() . \PHP_EOL;
echo 'Wallet Public Key: ' . $wallet->getPublicKey() . \PHP_EOL;
echo 'Wallet Private Key: ' . $wallet->getPrivateKey() . \PHP_EOL . \PHP_EOL;

// ======= GENERATE A WALLET FROM SCRATCH =======

echo 'Generating a new wallet:' . \PHP_EOL . \PHP_EOL;

$wallet = Wallet::generate();

echo 'Wallet seed: ' . $wallet->getSeedString() . \PHP_EOL;
echo 'Wallet address: ' . $wallet->getAddress() . \PHP_EOL;
echo 'Wallet Public Key: ' . $wallet->getPublicKey() . \PHP_EOL;
echo 'Wallet Private Key: ' . $wallet->getPrivateKey() . \PHP_EOL;
