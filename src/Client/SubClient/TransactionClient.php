<?php

declare(strict_types=1);

namespace XRPL\Client\SubClient;

use XRPL\Model\AbstractTransaction;
use XRPL\Model\Transaction\MultiSignedSubmittedTransaction;
use XRPL\Model\Transaction\SubmittedTransaction;
use XRPL\Model\Transaction\TransactionEntry;

readonly class TransactionClient extends AbstractClient
{
    public function submitOnly(
        string $transactionBlob,
        bool $failHard = false,
    ): SubmittedTransaction {
        $params = [
            'tx_blob' => $transactionBlob,
            'fail_hard' => $failHard,
        ];

        $response = $this->jsonRpcClient->getResult('submit', $params);

        return $this->serializer->deserialize(json_encode($response), SubmittedTransaction::class, 'json');
    }

    public function signAndSubmit(
        array $txJson,
        ?string $secret = null,
        ?string $seed = null,
        ?string $seedHex = null,
        ?string $passphrase = null,
        ?string $keyType = null,
        bool $failHard = false,
        bool $offline = false,
        ?bool $buildPath = null,
        ?int $feeMultMax = null,
        ?int $feeDivMax = null,
    ): SubmittedTransaction {
        $params = [
            'tx_json' => $txJson,
            'secret' => $secret,
            'seed' => $seed,
            'seed_hex' => $seedHex,
            'passphrase' => $passphrase,
            'key_type' => $keyType,
            'fail_hard' => $failHard,
            'offline' => $offline,
            'build_path' => $buildPath,
            'fee_mult_max' => $feeMultMax,
            'fee_div_max' => $feeDivMax,
        ];

        $response = $this->jsonRpcClient->getResult('submit', $params);

        return $this->serializer->deserialize(json_encode($response), SubmittedTransaction::class, 'json');
    }

    public function submitMultiSigned(
        array $transaction,
        bool $failHard = false,
    ): MultiSignedSubmittedTransaction {
        $params = [
            'tx_json' => $transaction,
            'fail_hard' => $failHard,
        ];

        $response = $this->jsonRpcClient->getResult('submit_multisigned', $params);

        return $this->serializer->deserialize(json_encode($response), MultiSignedSubmittedTransaction::class, 'json');
    }

    public function getTransactionAtLedger(
        string $transactionHash,
        ?string $ledgerHash = null,
        string|int|null $ledgerIndex = null,
    ): TransactionEntry {
        if ($ledgerHash === null && $ledgerIndex === null) {
            throw new \InvalidArgumentException('Either ledgerHash or ledgerIndex must be provided.');
        }

        if ($ledgerHash !== null && $ledgerIndex !== null) {
            throw new \InvalidArgumentException('Only one of ledgerHash or ledgerIndex can be provided.');
        }

        $params = [
            'tx_hash' => $transactionHash,
            'ledger_hash' => $ledgerHash,
            'ledger_index' => $ledgerIndex,
        ];

        $response = $this->jsonRpcClient->getResult('transaction_entry', $params);

        $transactionEntry = $this->serializer->deserialize(json_encode($response), TransactionEntry::class, 'json');

        if ($transactionEntry->transaction === null) {
            throw new \RuntimeException('Transaction not found.');
        }

        return $transactionEntry;
    }

    public function getTransaction(
        ?string $transactionHash = null,
        ?string $compactTransactionId = null,
        ?int $minLedger = null,
        ?int $maxLedger = null,
    ): AbstractTransaction {
        if (null === $transactionHash && null === $compactTransactionId) {
            throw new \InvalidArgumentException('Either transactionHash or compactTransactionId must be provided.');
        }

        if (null !== $transactionHash && null !== $compactTransactionId) {
            throw new \InvalidArgumentException('Only one of transactionHash or compactTransactionId can be provided.');
        }

        $params = [
            'transaction' => $transactionHash,
            'ctid' => $compactTransactionId,
            'min_ledger' => $minLedger,
            'max_ledger' => $maxLedger,
        ];

        $response = $this->jsonRpcClient->getResult('tx', $params);

        return $this->serializer->deserialize(json_encode($response), AbstractTransaction::class, 'json');
    }
}
