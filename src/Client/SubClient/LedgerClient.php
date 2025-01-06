<?php

declare(strict_types=1);

namespace XRPL\Client\SubClient;

use XRPL\Client\JsonRpcClient;
use XRPL\Denormalizer\TransactionDenormalizer;
use XRPL\Model\Ledger\LedgerClosed;
use XRPL\Model\Ledger\LedgerCurrent;
use XRPL\Model\Ledger\LedgerData;
use XRPL\Model\Ledger\LedgerEntry;
use XRPL\Model\Ledger\LedgerResult;
use XRPL\Service\Serializer;

readonly class LedgerClient
{
    private TransactionDenormalizer $transactionDeserializer;

    public function __construct(
        private Serializer $serializer,
        private JsonRpcClient $jsonRpcClient,
    ) {
        $this->transactionDeserializer = new TransactionDenormalizer($this->serializer);
    }

    /**
     * @note If `transactions` is set to true but `expand` is set to false, only the `transactionIds` field will be populated.
     */
    public function getLedger(
        ?string $ledgerHash = null,
        ?string $ledgerIndex = null,
        bool $transactions = false,
        bool $expand = false,
        bool $ownerFunds = false,
        bool $includeQueuedTransactions = false,
    ): LedgerResult {
        $payload = [
            'transactions' => $transactions,
            'expand' => $expand,
            'owner_funds' => $ownerFunds,
            'queue' => $includeQueuedTransactions,
        ];

        if ($ledgerHash !== null) {
            $payload['ledger_hash'] = $ledgerHash;
        }
        if ($ledgerIndex !== null) {
            $payload['ledger_index'] = $ledgerIndex;
        }

        $result = $this->jsonRpcClient->getResult('ledger', $payload);

        /** @var LedgerResult $ledgerResponse */
        $ledgerResponse = $this->serializer->deserialize(json_encode($result), LedgerResult::class, 'json');

        if ($transactions === true && $expand === false) {
            $ledgerResponse->ledger->transactionIds = $result->ledger->transactions;
        }

        if ($transactions === true && $expand === true) {
            $ledgerResponse->ledger->transactions = $this->transactionDeserializer->deserializeList($result->ledger->transactions);
        }

        return $ledgerResponse;
    }

    public function getLedgerClosed(): LedgerClosed
    {
        $result = $this->jsonRpcClient->getResult('ledger_closed');

        /** @var LedgerClosed $ledgerClosed */
        $ledgerClosed = $this->serializer->deserialize(json_encode($result), LedgerClosed::class, 'json');

        return $ledgerClosed;
    }

    public function getLedgerCurrent(): LedgerCurrent
    {
        $result = $this->jsonRpcClient->getResult('ledger_current');

        /** @var LedgerCurrent $ledgerCurrent */
        $ledgerCurrent = $this->serializer->deserialize(json_encode($result), LedgerCurrent::class, 'json');

        return $ledgerCurrent;
    }

    public function getLedgerData(
        ?string $ledgerHash = null,
        ?int $ledgerIndex = null,
        bool $binary = false,
        ?int $limit = null,
        mixed $marker = null,
        ?string $type = null,
    ): LedgerData {
        $payload = [
            'binary' => $binary,
        ];

        if ($ledgerHash !== null) {
            $payload['ledger_hash'] = $ledgerHash;
        }
        if ($ledgerIndex !== null) {
            $payload['ledger_index'] = $ledgerIndex;
        }
        if ($limit !== null) {
            $payload['limit'] = $type;
        }
        if ($marker !== null) {
            $payload['marker'] = $type;
        }
        if ($type !== null) {
            $type = LedgerEntry::from($type);

            $payload['type'] = $type->value;
        }

        $result = $this->jsonRpcClient->getResult('ledger_data', $payload);

        /** @var LedgerData $ledgerData */
        $ledgerData = $this->serializer->deserialize(json_encode($result), LedgerData::class, 'json');

        return $ledgerData;
    }

    public function getLedgerEntry(
        array $parameters = [],
        bool $binary = false,
        ?string $ledgerHash = null,
        string|int|null $ledgerIndex = null,
        ?bool $includeDeleted = null,
    ): LedgerEntry {
        $payload = [
            'binary' => $binary,
        ];
        $payload = array_merge($payload, $parameters);

        if ($ledgerHash !== null) {
            $payload['ledger_hash'] = $ledgerHash;
        }
        if ($ledgerIndex !== null) {
            $payload['ledger_index'] = $ledgerIndex;
        }
        if ($includeDeleted !== null) {
            $payload['include_deleted'] = $includeDeleted;
        }

        $result = $this->jsonRpcClient->getResult('ledger_entry', $payload);

        /** @var LedgerEntry $ledgerEntry */
        $ledgerEntry = $this->serializer->deserialize(json_encode($result), LedgerEntry::class, 'json');

        return $ledgerEntry;
    }
}
