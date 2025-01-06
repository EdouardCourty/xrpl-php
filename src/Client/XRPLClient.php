<?php

declare(strict_types=1);

namespace XRPL\Client;

use XRPL\Client\SubClient\LedgerClient;
use XRPL\Client\SubClient\PaymentChannelClient;
use XRPL\Client\SubClient\ServerInfoClient;
use XRPL\Client\SubClient\UtilityClient;
use XRPL\Service\Serializer;

/**
 * @author Edouard Courty <edouard.courty2@gmail.com>
 */
readonly class XRPLClient
{
    private JsonRpcClient $jsonRpcClient;
    private Serializer $serializer;

    public LedgerClient $ledger;
    public PaymentChannelClient $paymentChannelClient;
    public ServerInfoClient $serverInfo;
    public UtilityClient $utility;

    public function __construct(
        string $url,
    ) {
        $this->jsonRpcClient = new JsonRpcClient($url);
        $this->serializer = new Serializer();

        $this->ledger = new LedgerClient($this->serializer, $this->jsonRpcClient);
        $this->paymentChannelClient = new PaymentChannelClient($this->serializer, $this->jsonRpcClient);
        $this->serverInfo = new ServerInfoClient($this->serializer, $this->jsonRpcClient);
        $this->utility = new UtilityClient($this->serializer, $this->jsonRpcClient);
    }
}
