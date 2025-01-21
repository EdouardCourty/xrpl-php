<?php

declare(strict_types=1);

namespace XRPL\Client\SubClient;

use XRPL\Model\Utility\Ping;
use XRPL\Model\Utility\Random;

/**
 * @author Edouard Courty
 */
readonly class UtilityClient extends AbstractClient
{
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
