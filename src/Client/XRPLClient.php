<?php

declare(strict_types=1);

namespace XRPL\Client;

use XRPL\Client\SubClient\AccountClient;
use XRPL\Client\SubClient\LedgerClient;
use XRPL\Client\SubClient\PathOrderBookClient;
use XRPL\Client\SubClient\PaymentChannelClient;
use XRPL\Client\SubClient\ServerInfoClient;
use XRPL\Client\SubClient\TransactionClient;
use XRPL\Client\SubClient\UtilityClient;
use XRPL\Service\Serializer;
use XRPL\ValueObject\Wallet;

/**
 * @author Edouard Courty <edouard.courty2@gmail.com>
 */
readonly class XRPLClient
{
    private JsonRpcClient $jsonRpcClient;
    private Serializer $serializer;

    public AccountClient $account;
    public LedgerClient $ledger;
    public TransactionClient $transaction;
    public PathOrderBookClient $pathOrderBook;
    public PaymentChannelClient $paymentChannels;
    public ServerInfoClient $serverInfo;
    public UtilityClient $utility;

    public function __construct(
        string $url,
    ) {
        $this->jsonRpcClient = new JsonRpcClient($url);
        $this->serializer = new Serializer();

        $this->account = new AccountClient($this->serializer, $this->jsonRpcClient);
        $this->ledger = new LedgerClient($this->serializer, $this->jsonRpcClient);
        $this->transaction = new TransactionClient($this->serializer, $this->jsonRpcClient);
        $this->pathOrderBook = new PathOrderBookClient($this->serializer, $this->jsonRpcClient);
        $this->paymentChannels = new PaymentChannelClient($this->serializer, $this->jsonRpcClient);
        $this->serverInfo = new ServerInfoClient($this->serializer, $this->jsonRpcClient);
        $this->utility = new UtilityClient($this->serializer, $this->jsonRpcClient);
    }

    /**
     * Fill the potentially missing fields of a transaction (Sequence, Fee, LastLedgerSequence)
     */
    public function autofillTransaction(array &$transactionData): void
    {
        if (isset($transactionData['Sequence']) === false && isset($transactionData['Account']) === true) {
            $accountData = $this->account->getAccountInfo($transactionData['Account']);

            $transactionData['Sequence'] = $accountData->accountData->sequence;
        }

        if (isset($transactionData['Fee']) === false) {
            $currentBaseFee = (int)$this->serverInfo->getFee()->drops->baseFee;
            $currentServerState = $this->serverInfo->getServerState()->state;

            // Most accurate way of calculating the current transaction fee
            $fee = ($currentBaseFee * $currentServerState->loadFactor) / $currentServerState->loadBase;
            $transactionData['Fee'] = (string)$fee;
        }

        if (isset($transactionData['LastLedgerSequence']) === false) {
            $lastLedger = $this->ledger->getLedger();

            $transactionData['LastLedgerSequence'] = $lastLedger->ledgerIndex + 15;
        }
    }

    /**
     * Autofill and sign the transaction
     */
    public function autofillAndSign(array $transactionData, Wallet $wallet): string
    {
        $this->autofillTransaction($transactionData);

        return $wallet->sign($transactionData);
    }

    /**
     * @param bool $autofill Whether to autofill the transaction before signing it
     *
     * @return string The hash of the submitted transaction
     */
    public function submitTransaction(array $transactionData, Wallet $wallet, bool $autofill = true): string
    {
        $transactionBlob = $autofill === true
            ? $this->autofillAndSign($transactionData, $wallet)
            : $wallet->sign($transactionData);

        return $this->transaction->submitOnly($transactionBlob)->txJson['hash'];
    }
}
