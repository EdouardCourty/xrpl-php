<?php

declare(strict_types=1);

namespace XRPL\Utils;

/**
 * @author Edouard Courty
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
        $filteredParams = array_filter($this->params, static fn($value) => $value !== null);
        $params = empty($filteredParams) ? [] : [$filteredParams];

        return [
            'jsonrpc' => $this->version,
            'method' => $this->method,
            'params' => $params,
            'id' => $this->id,
        ];
    }
}
