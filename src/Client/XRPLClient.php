<?php

declare(strict_types=1);

namespace XRPL\Client;

use XRPL\Client\SubClient\AccountClient;
use XRPL\Client\SubClient\LedgerClient;
use XRPL\Client\SubClient\PaymentChannelClient;
use XRPL\Client\SubClient\PaymentClient;
use XRPL\Client\SubClient\ServerInfoClient;
use XRPL\Client\SubClient\TransactionClient;
use XRPL\Client\SubClient\UtilityClient;
use XRPL\Service\Serializer;

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
    public PaymentClient $payment;
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
        $this->payment = new PaymentClient($this->serializer, $this->jsonRpcClient);
        $this->paymentChannels = new PaymentChannelClient($this->serializer, $this->jsonRpcClient);
        $this->serverInfo = new ServerInfoClient($this->serializer, $this->jsonRpcClient);
        $this->utility = new UtilityClient($this->serializer, $this->jsonRpcClient);
    }
}
