<?php

declare(strict_types=1);

namespace XRPL\Client;

use XRPL\Exception\JsonRpcException;
use XRPL\Utils\JsonRpcRequest;
use XRPL\Utils\UuidGenerator;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * @author Edouard Courty <edouard.courty2@gmail.com>
 */
readonly class JsonRpcClient
{
    private const int DEFAULT_TIMEOUT = 10;

    private HttpClientInterface $httpClient;

    public function __construct(string $url)
    {
        $this->httpClient = HttpClient::createForBaseUri($url);
    }

    public function request(string $method, array $params = [], int $timeout = self::DEFAULT_TIMEOUT): bool|string|int|float|array
    {
        $requestPayload = new JsonRpcRequest(UuidGenerator::v4(), $method, $params);
        $response = null;

        try {
            $response = $this->httpClient->request('POST', '/', [
                'json' => $requestPayload->toArray(),
                'timeout' => $timeout,
            ]);

            $statusCode = $response->getStatusCode();

            if ($statusCode !== 200) {
                throw new JsonRpcException("HTTP error: {$statusCode}", $response);
            }

            $content = $response->toArray(false);

            if (isset($content['error'])) {
                $error = $content['error'];
                throw new JsonRpcException("RPC Error {$error['code']}: {$error['message']}", $response);
            }

            return $content['result'];
        } catch (\Throwable $e) {
            throw new JsonRpcException("Request failed: " . $e->getMessage(), $response, $e);
        }
    }
}
