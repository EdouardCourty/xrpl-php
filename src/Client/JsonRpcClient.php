<?php

declare(strict_types=1);

namespace XRPL\Client;

use XRPL\Exception\JsonRpcException;
use XRPL\Model\Response\RippledResponse;
use XRPL\Service\Serializer;
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
    private Serializer $serializer;

    public function __construct(string $url)
    {
        $this->httpClient = HttpClient::createForBaseUri($url);
        $this->serializer = new Serializer();
    }

    public function request(string $method, array $params = [], int $timeout = self::DEFAULT_TIMEOUT)
    {
        $request = new JsonRpcRequest(UuidGenerator::v4(), $method, $params);
        $response = null;

        try {
            return $this->execute($request, $timeout);
        } catch (\Throwable $e) {
            throw new JsonRpcException("Request failed: " . $e->getMessage(), $response, $e);
        }
    }

    public function getResult(string $method, array $params = [], int $timeout = self::DEFAULT_TIMEOUT): mixed
    {
        $response = $this->request($method, $params, $timeout);

        return $response->result;
    }

    public function getJson(string $method, array $params = [], int $timeout = self::DEFAULT_TIMEOUT): array
    {
        $response = $this->getResult($method, $params, $timeout);

        return json_decode(json_encode($response), true);
    }

    public function execute(JsonRpcRequest $request, int $timeout): RippledResponse
    {
        $response = $this->httpClient->request('POST', '/', [
            'json' => $request->toArray(),
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

        /** @var RippledResponse $rippledResponse */
        $rippledResponse = $this->serializer->deserialize(
            $response->getContent(),
            RippledResponse::class,
            'json',
        );

        return $rippledResponse;
    }
}
