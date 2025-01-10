<?php

declare(strict_types=1);

namespace XRPL\Client\SubClient;

use XRPL\Client\JsonRpcClient;
use XRPL\Service\Serializer;

/**
 * @author Edouard Courty <edouard.courty2@gmail.com>
 */
abstract readonly class AbstractClient
{
    public function __construct(
        protected Serializer $serializer,
        protected JsonRpcClient $jsonRpcClient,
    ) {
    }
}
