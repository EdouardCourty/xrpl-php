<?php

declare(strict_types=1);

namespace XRPL\Client\SubClient;

use XRPL\Client\JsonRpcClient;
use XRPL\Service\Serializer;

abstract readonly class AbstractClient
{
    public function __construct(
        protected Serializer $serializer,
        protected JsonRpcClient $jsonRpcClient,
    ) {
    }
}
