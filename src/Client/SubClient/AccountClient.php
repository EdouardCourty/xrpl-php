<?php

declare(strict_types=1);

namespace XRPL\Client\SubClient;

use XRPL\Client\JsonRpcClient;
use XRPL\Enum\AccountLedgerEntryEnum;
use XRPL\Model\Account\AccountChannels;
use XRPL\Model\Account\AccountCurrencies;
use XRPL\Model\Account\AccountInfo;
use XRPL\Model\Account\AccountLines;
use XRPL\Model\Account\AccountNFTs;
use XRPL\Model\Account\AccountObjects;
use XRPL\Model\Account\AccountOffers;
use XRPL\Model\Account\AccountTransactions;
use XRPL\Model\Account\GatewayBalances;
use XRPL\Model\Account\NoRippleCheck;
use XRPL\Model\Utility\Ping;
use XRPL\Model\Utility\Random;
use XRPL\Service\Denormalizer\TransactionDenormalizer;
use XRPL\Service\Serializer;

readonly class AccountClient
{
    private TransactionDenormalizer $transactionDenormalizer;

    public function __construct(
        private Serializer $serializer,
        private JsonRpcClient $jsonRpcClient,
    ) {
        $this->transactionDenormalizer = new TransactionDenormalizer($this->serializer);
    }

    public function getAccountChannels(
        string $address,
        ?string $destinationAccount = null,
        ?string $ledgerHash = null,
        ?int $limit = null,
        mixed $marker = null,
    ): AccountChannels {
        $params = [
            'account' => $address,
            'destination_account' => $destinationAccount,
            'ledger_hash' => $ledgerHash,
            'limit' => $limit,
            'marker' => $marker,
        ];

        $response = $this->jsonRpcClient->getResult('account_channels', $params);

        return $this->serializer->deserialize(json_encode($response), AccountChannels::class, 'json');
    }

    public function getAccountCurrencies(
        string $account,
        ?string $ledgerHash = null,
        string|int|null $ledgerIndex = null,
    ): AccountCurrencies {
        $params = [
            'account' => $account,
            'ledger_hash' => $ledgerHash,
            'ledger_index' => $ledgerIndex,
        ];

        $response = $this->jsonRpcClient->getResult('account_currencies', $params);

        return $this->serializer->deserialize(json_encode($response), AccountCurrencies::class, 'json');
    }

    public function getAccountInfo(
        string $account,
        ?string $ledgerHash = null,
        string|int|null $ledgerIndex = null,
        ?int $limit = null,
        mixed $marker = null,
    ): AccountInfo {
        $params = [
            'account' => $account,
            'ledger_hash' => $ledgerHash,
            'ledger_index' => $ledgerIndex,
            'limit' => $limit,
            'marker' => $marker,
        ];

        $response = $this->jsonRpcClient->getResult('account_info', $params);

        return $this->serializer->deserialize(json_encode($response), AccountInfo::class, 'json');
    }

    public function getAccountLines(
        string $account,
        ?string $ledgerHash = null,
        string|int|null $ledgerIndex = null,
        ?string $peer = null,
        ?int $limit = null,
        mixed $marker = null,
    ): AccountLines {
        $params = [
            'account' => $account,
            'ledger_hash' => $ledgerHash,
            'ledger_index' => $ledgerIndex,
            'peer' => $peer,
            'limit' => $limit,
            'marker' => $marker,
        ];

        $response = $this->jsonRpcClient->getResult('account_lines', $params);

        return $this->serializer->deserialize(json_encode($response), AccountLines::class, 'json');
    }

    public function getAccountNFTs(
        string $account,
        ?string $ledgerHash = null,
        string|int|null $ledgerIndex = null,
        ?int $limit = null,
        mixed $marker = null,
    ): AccountNFTs {
        $params = [
            'account' => $account,
            'ledger_hash' => $ledgerHash,
            'ledger_index' => $ledgerIndex,
            'limit' => $limit,
            'marker' => $marker,
        ];

        $response = $this->jsonRpcClient->getResult('account_nfts', $params);

        return $this->serializer->deserialize(json_encode($response), AccountNFTs::class, 'json');
    }

    public function getAccountObjects(
        string $account,
        bool $deletionBlockersOnly = false,
        ?string $ledgerHash = null,
        string|int|null $ledgerIndex = null,
        ?int $limit = null,
        mixed $marker = null,
        ?string $type = null,
    ): AccountObjects {
        $type = AccountLedgerEntryEnum::tryFrom((string) $type)?->value;

        $params = [
            'account' => $account,
            'deletion_blockers_only' => $deletionBlockersOnly,
            'ledger_hash' => $ledgerHash,
            'ledger_index' => $ledgerIndex,
            'limit' => $limit,
            'marker' => $marker,
            'type' => $type,
        ];

        $response = $this->jsonRpcClient->getResult('account_objects', $params);

        return $this->serializer->deserialize(json_encode($response), AccountObjects::class, 'json');
    }

    public function getAccountOffers(
        string $account,
        ?string $ledgerHash = null,
        string|int|null $ledgerIndex = null,
        ?int $limit = null,
        mixed $marker = null,
    ): AccountOffers {
        $params = [
            'account' => $account,
            'ledger_hash' => $ledgerHash,
            'ledger_index' => $ledgerIndex,
            'limit' => $limit,
            'marker' => $marker,
        ];

        $response = $this->jsonRpcClient->getResult('account_offers', $params);

        return $this->serializer->deserialize(json_encode($response), AccountOffers::class, 'json');
    }

    public function getAccountTransactions(
        string $account,
        ?string $transactionType = null,
        ?int $ledgerIndexMin = null,
        ?int $ledgerIndexMax = null,
        ?string $ledgerHash = null,
        string|int|null $ledgerIndex = null,
        bool $forward = false,
        ?int $limit = null,
        mixed $marker = null,
    ): AccountTransactions
    {
        $providedParams = array_filter([
            'ledger_index_min' => $ledgerIndexMin,
            'ledger_index_max' => $ledgerIndexMax,
            'ledger_hash' => $ledgerHash,
            'ledger_index' => $ledgerIndex,
        ]);

        if (\count($providedParams) > 1) {
            throw new \InvalidArgumentException(
                'Only one of $ledgerIndexMin, $ledgerIndexMax, $ledgerHash, $ledgerIndex should be set.',
            );
        }

        if (($ledgerIndex !== null || $ledgerHash !== null) && ($ledgerIndexMin !== null || $ledgerIndexMax !== null)) {
            throw new \InvalidArgumentException(
                'You cannot use $ledgerIndexMin or $ledgerIndexMax with $ledgerIndex or $ledgerHash.',
            );
        }

        $params = [
            'account' => $account,
            'transaction_type' => $transactionType,
            'ledger_index_min' => $ledgerIndexMin,
            'ledger_index_max' => $ledgerIndexMax,
            'ledger_hash' => $ledgerHash,
            'ledger_index' => $ledgerIndex,
            'binary' => false, // Could be implemented later on if requested, I don't think it is very useful tho.
            'forward' => $forward,
            'limit' => $limit,
            'marker' => $marker,
        ];

        $response = $this->jsonRpcClient->getResult('account_tx', $params);

        $accountTransaction = $this->serializer->deserialize(json_encode($response), AccountTransactions::class, 'json');
        $accountTransaction->transactions = $this->transactionDenormalizer->deserializeListForAccount($response->transactions);

        return $accountTransaction;
    }

    public function getGatewayBalances(
        string $account,
        bool $strict = false,
        string|array|null $hotwallet = null,
        string|int|null $ledgerIndex = null,
        ?string $ledgerHash = null,
    ): GatewayBalances {
        $params = [
            'account' => $account,
            'strict' => $strict,
            'hotwallet' => $hotwallet,
            'ledger_index' => $ledgerIndex,
            'ledger_hash' => $ledgerHash,
        ];

        $response = $this->jsonRpcClient->getResult('gateway_balances', $params);

        return $this->serializer->deserialize(json_encode($response), GatewayBalances::class, 'json');
    }

    public function getNoRippleCheck(
        string $account,
        string $role,
        bool $transactions = false,
        ?int $limit = null,
        ?string $ledgerHash = null,
        string|int|null $ledgerIndex = null,
    ): NoRippleCheck {
        if (false === \in_array($role, [NoRippleCheck::ROLE_GATEWAY, NoRippleCheck::ROLE_USER], true)) {
            throw new \InvalidArgumentException('Role must be either gateway or user');
        }

        $params = [
            'account' => $account,
            'role' => $role,
            'transactions' => $transactions,
            'limit' => $limit,
            'ledger_hash' => $ledgerHash,
            'ledger_index' => $ledgerIndex,
        ];

        $response = $this->jsonRpcClient->getResult('noripple_check', $params);

        $noRippleCheck = $this->serializer->deserialize(json_encode($response), NoRippleCheck::class, 'json');
        $noRippleCheck->transactions = $this->transactionDenormalizer->deserializeList($response->transactions ?? []);

        return $noRippleCheck;
    }
}
