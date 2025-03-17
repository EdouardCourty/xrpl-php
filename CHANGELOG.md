# XRPL-PHP Changelog

This file contains information about every addition, update and deletion in the XRPL-PHP library.  
It is recommended to read this file before updating the library to a new version.

## v1.0.0

Initial release of the project.

#### Additions

- Created the `XRPL\Client\XRPLClient` class to interact with XRP Ledger nodes
    - Supports ALL active/non-deprecated JSON-RPC methods
    - Added the corresponding response models (`XRPL\Model`)
- Created `Wallet`, `Seed`, `KeyPair` and related services to:
  - Create seeds, key pairs and wallets
  - Derive wallets from seeds
- Created `XRPL\Helper\XRPConverter` to easily convert XRP amounts from tokens to drops and back
- Integrated `XRPL\Service\Faucet` to fund testnet/devnet Wallets
- Added unit tests

## v1.1.0

This releases brings support for transaction building, serializing and submitting on the XRP Ledger.

#### Additions

- Created `TransactionEncoder` and its usage in `XRPLClient` to handle transaction creation.
- Added necessary types in `XRPL\Type` to handle binary serialization of all supported XRP Ledger internal types (AccountID, Amount, Currency, Hashes...)
- 

#### Updates

- `XRPLClient` can now autofill, serialize, sign and submit transactions 
- `Wallet::sign` has an alias to `TransactionEncoder::sign`

## v1.2.0

This release brings support for external `Wallet` and `KeyPair` integrations using the contracts defined in `XRPL\Contract`.

#### Additions

- Added the `XRPL\Contract\WalletInterface` and `XRPL\Contract\KeyPairInterface` that can be used to use other wallet and keypair classes than the ones provided with `ecourty/xrpl-php`.

## v1.3.0

This release brings support for non-standard currency codes.

#### Additions

- Added `XRPL\Helper\CurrencyConverter` to convert standard and non-standard currency codes from their textual form to their hexadecimal form.
- Added unit tests covering the additions

#### Updates

- The `Currency` type can now handle non-standard currency forms like `RLUSD`, `SOLO`...
- Added unit tests covering the updated
