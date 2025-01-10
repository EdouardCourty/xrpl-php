# xrpl-php

[![PHP CI](https://github.com/EdouardCourty/xrpl-php/actions/workflows/php_ci.yml/badge.svg)](https://github.com/EdouardCourty/xrpl-php/actions/workflows/php_ci.yml)

A PHP library to interact with an XRP Ledger Node.

## Features

This library provides a simple way to interact with an XRP Ledger Node. <br />
It covers 100% of the public XRP Ledger API JSON-RPC methods at date of writing.

The library is designed to be simple to use and easy to understand. <br />
`xrpl-php` allows you to:

- Communicate with the XRP Ledger
- Manage and generate XRP Ledger wallets
- Fund your testnet / devnet wallets using the Faucet
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

use XRPL\Service\Wallet\WalletGenerator;
use XRPL\ValueObject\Wallet;

$newWallet = WalletGenerator::generate(Wallet::ALGORITHM_SECP256K1);
// Also works as Wallet::generate(Wallet::ALGORITHM_SECP256K1);

$seed = 'sEd7Fv8k1vF9R5kFtPbQG7wYyVr'; // Example seed, do not reuse
$importedWallet = WalletGenerator::generateFromSeed($seed);
// Also works as Wallet::generateFromSeed($seed);
```

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

## Examples

1. Getting the balance of an account
    ```php
    <?php
    
    use XRPL\Client\XRPLClient;
    
    $client = new XRPLClient('https://s1.ripple.com:51234');
    
    $address = 'r9cZA1mLK5R5Am25ArfXFmqgNwjZgnfk59';
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
    
    $lastLedger = $client->ledger->getLedger(transactions: true, expand: true);
    
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
