<?php

declare(strict_types=1);

namespace XRPL\Utils;

/**
 * @author Edouard Courty <edouard.courty2@gmail.com>
 */
readonly class JsonRpcRequest
{
    public const string JSON_RPC_VERSION = '2.0';

    public function __construct(
        private string $id,
        private string $method,
        private array $params,
        private string $version = self::JSON_RPC_VERSION,
    ) {
    }

    public function toArray(): array
    {
        return [
            'jsonrpc' => $this->version,
            'method' => $this->method,
            'params' => $this->params,
            'id' => $this->id,
        ];
    }
}
