<?php

declare(strict_types=1);

namespace XRPL\Client\SubClient;

use XRPL\Client\JsonRpcClient;
use XRPL\Model\Utility\Ping;
use XRPL\Model\Utility\Random;
use XRPL\Service\Serializer;

readonly class UtilityClient
{
    public function __construct(
        private Serializer $serializer,
        private JsonRpcClient $jsonRpcClient,
    ) {
    }

    public function ping(): Ping
    {
        $response = $this->jsonRpcClient->getResult('ping');

        return $this->serializer->deserialize(json_encode($response), Ping::class, 'json');
    }

    public function random(): Random
    {
        $response = $this->jsonRpcClient->getResult('random');

        return $this->serializer->deserialize(json_encode($response), Random::class, 'json');
    }
}
