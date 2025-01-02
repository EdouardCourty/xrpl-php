<?php

declare(strict_types=1);

namespace XRPL\Client;

/**
 * @author Edouard Courty <edouard.courty2@gmail.com>
 */
readonly class XRPLClient
{
    private JsonRpcClient $jsonRpcClient;

    public function __construct(
        string $url,
    ) {
        $this->jsonRpcClient = new JsonRpcClient($url);
    }
}
