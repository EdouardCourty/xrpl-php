<?php

declare(strict_types=1);

namespace XRPL\Client\SubClient;

use XRPL\Exception\TransactionNotFoundException;
use XRPL\Model\AbstractTransaction;
use XRPL\Model\Transaction\MultiSignedSubmittedTransaction;
use XRPL\Model\Transaction\SubmittedTransaction;
use XRPL\Model\Transaction\TransactionEntry;

/**
 * @author Edouard Courty <edouard.courty2@gmail.com>
 */
readonly class TransactionClient extends AbstractClient
{
    private const string TX_SUBMIT_SUCCESS = 'tesSUCCESS';

    /**
     * @param bool $ignoreFailure If true, the method will not throw an exception if the transaction submission fails.
     */
    public function submitOnly(
        string $transactionBlob,
        bool $failHard = false,
        bool $ignoreFailure = false,
    ): SubmittedTransaction {
        $params = [
            'tx_blob' => $transactionBlob,
            'fail_hard' => $failHard,
        ];

        $response = $this->jsonRpcClient->getResult('submit', $params);

        $submitResponse = $this->serializer->deserialize(json_encode($response), SubmittedTransaction::class, 'json');

        if ($submitResponse->engineResult !== self::TX_SUBMIT_SUCCESS && $ignoreFailure === false) {
            throw new \RuntimeException('Transaction submission failed: ' . $submitResponse->engineResult);
        }

        return $submitResponse;
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

    /**
     * @throws TransactionNotFoundException
     */
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
            throw TransactionNotFoundException::fromIdentifier($transactionHash);
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
