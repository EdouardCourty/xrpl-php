# xrpl-php

[![PHP CI](https://github.com/EdouardCourty/xrpl-php/actions/workflows/php_ci.yml/badge.svg)](https://github.com/EdouardCourty/xrpl-php/actions/workflows/php_ci.yml)

A PHP library to interact with an XRP Ledger Node.

## Table of Contents

- [Features](#features)
- [Installation](#installation)
- [Usage](#usage)
  - [XRP Ledger Communication](#xrp-ledger-communication)
  - [XRP Ledger Wallet Management](#xrp-ledger-wallet-management)
  - [Submitting a transaction to the XRP Ledger](#submitting-a-transaction-to-the-xrp-ledger)
  - [Code examples](#code-examples)
  - [Adding funds on a TestNet / DevNet wallet](#adding-funds-on-a-testnet--devnet-wallet)
- [Contracts](#contracts)
- [Examples](#examples)

## Features

This library provides a simple way to interact with an XRP Ledger Node. <br />
It covers 100% of the public XRP Ledger API JSON-RPC methods at date of writing.

The library is designed to be simple to use and easy to understand. <br />
`xrpl-php` allows you to:

- Communicate with the XRP Ledger
- Manage and generate XRP Ledger wallets
- Fund your testnet / devnet wallets using the Faucet
- Sign and submit transactions to the XRP Ledger
  - Support for Single-Signature and Multi-Signature transactions
- Translate XRP to Drops amounts

Here are some [usage examples](#examples).

## Installation

Install the package using [Composer](https://getcomposer.org/): <br />

```bash
composer require ecourty/xrpl-php
```

## Usage

#### XRP Ledger Communication
If you wish to communicate with an XRP Ledger Node, you can use the `XRPLClient` class as follows: <br />

```php
<?php

use XRPL\Client\XRPLClient;

$client = new XRPLClient('https://s1.ripple.com:51234'); // Public XRP Ledger Node

// Testnet Public Node: https://s.altnet.rippletest.net:51234
// Devnet Public Node: https://s.devnet.rippletest.net:51234
```

#### XRP Ledger Wallet Management
`xrpl-php` allows you to create and import XRP Ledger Wallets. <br />
You can generate or import a wallet as follows: <br />

```php
<?php

use XRPL\Enum\Algorithm;
use XRPL\Service\Wallet\WalletGenerator;
use XRPL\ValueObject\Wallet;

$newWallet = WalletGenerator::generate(Algorithm::SECP256K1);
// Also works as Wallet::generate(Algorithm::ALGORITHM_SECP256K1);

$seed = 'sEd7Fv8k1vF9R5kFtPbQG7wYyVr'; // Example seed, do not reuse
$importedWallet = WalletGenerator::generateFromSeed($seed);
// Also works as Wallet::generateFromSeed($seed);
```

#### Submitting a transaction to the XRP Ledger

You can submit a transaction to the XRP Ledger with multiple approaches: <br />

```php
<?php

use XRPL\Client\XRPLClient;
use XRPL\ValueObject\Wallet;

$client = new XRPLClient('https://s1.ripple.com:51234');

$wallet = Wallet::generateFromSeed('...')

/**
 * @see https://xrpl.org/docs/references/protocol/transactions/types
 */
$transactionData = [
    'Account' => $wallet->getAddress(),
    'TransactionType' => 'Payment',
    'Destination' => 'r9cZA1mLK5R5Am25ArfXFmqgNwjZgnfk59',
    'Amount' => '1000000',
    // ...
];

// 1. Use the XRPLCLient to submit the transaction directly
$client->submitSingleSignTransaction($transactionData, $wallet);
$client->submitMultiSignTransaction($transactionData, $wallet, $signers);

// 2. Hash the transaction yourself and submit it
$client->autofillTransaction(transactionData); // Add the missing fields if not already set (Fee, Sequence, LastLedgerSequence)
$transactionBlob = $wallet->sign($transactionData);

$client->transaction->submitOnly($transactionBlob);
```

**Autofilling Transaction Fields**

The XRP Ledger requires some fields to be set in the transaction data. <br />
These fields are:
- `Fee`
- `Sequence`
- `LastLedgerSequence`

If you want to automatically fill these fields in the transaction data, you can use the `autofillTransaction` method. <br />
This will query the correct values from your account and fill them in the transaction data.

#### Code examples

Code examples can be found in the [examples](examples) directory. <br />

#### Adding funds on a TestNet / DevNet wallet

You can add funds to a TestNet / DevNet wallet using either the `Wallet` class or the `Faucet` class. <br />

1. Adding funds using the `Wallet` class
    ```php
    <?php
    
    use XRPL\ValueObject\Wallet;
    
    $wallet = Wallet::generate(); // Or import a wallet using ::generateFromSeed
    $wallet->addFunds(); // Adds 100 XRP to the wallet
    ```

2. Adding funds using the `Faucet` class

    ```php
    <?php
    
    use XRPL\Service\Faucet;
    
    $wallet = Wallet::generate(); // Or import a wallet using ::generateFromSeed
    Faucet::addFunds($wallet); // Adds 100 XRP to the wallet
    ```

## Contracts

`xrpl-php` implements two contracts to allow for seamless integration with external systems:
- `XRPL\Contract\Wallet`
- `XRPL\Contract\KeyPair`

The provided `Wallet` and `KeyPair` classes implement these contracts. <br />

You can implement these interfaces in your own classes to allow for easy integration with `xrpl-php`. <br />

## Examples

1. Getting the balance of an account
    ```php
    <?php
    
    use XRPL\Client\XRPLClient;
    
    $client = new XRPLClient('https://s1.ripple.com:51234');
    
    $accountLines = $client->account->getAccountLines('r9cZA1mLK5R5Am25ArfXFmqgNwjZgnfk59');
    
    foreach ($accountLines->lines as $line) {
        $currency = $line->currency;
        $amount = $line->balance;
    
        // Implement your own logic
    }
    ```

2. Getting the last transactions of a Ledger (by hash / index)

    _If no ledger hash or index is passed, the latest Ledger data will be returned._
    ```php
    <?php
    
    $lastLedger = $client->ledger->getLedger(
        ledgerIndex: 93392983,
        transactions: true,
        expand: true
    );
    
    foreach ($lastLedger->ledger->transactions as $transaction) {
        $txHash = $transaction->hash;
        $txAmount = $transaction->takerGets->getValue();
        $txType = $transaction->TransactionType;
    
        // Implement your own logic
    }
    ```

3. Getting the NFTs of an account
    ```php
    <?php

    $accountNFTs = $client->account->getAccountNFTs('r9cZA1mLK5R5Am25ArfXFmqgNwjZgnfk59');
    
    foreach ($accountNFTs->accountNfts as $nft) {
        $nftId = $nft->id;
        $nftOwner = $nft->owner;
        $nftIssuer = $nft->issuer;
    
        // Implement your own logic
    }
    ```

4. Trading (Paths & Order Book)
    ```php
    <?php
    
    $bookChanges = $client->pathOrderBook->getBookChanges(
    
    );
    
    foreach ($bookChanges->changes as $change) {
        $open = $change->open;
        $close = $change->close;
    
        $lowest = $change->low;
        $highest = $change->high; // More data is available in the model
    
        // Implement your own logic
    }
    ```

&copy; Edouard Courty, 2025
