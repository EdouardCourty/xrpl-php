<?php

declare(strict_types=1);

namespace XRPL\Client;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use XRPL\Exception\JsonRpcException;
use XRPL\Model\Response\RippledResponse;
use XRPL\Service\Serializer;
use XRPL\Utils\JsonRpcRequest;
use XRPL\Utils\UuidGenerator;

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

    /**
     * @throws JsonRpcException
     */
    public function request(string $method, array $params = [], int $timeout = self::DEFAULT_TIMEOUT): RippledResponse
    {
        $request = new JsonRpcRequest(UuidGenerator::v4(), $method, $params);

        return $this->execute($request, $timeout);
    }

    public function getResult(string $method, array $params = [], int $timeout = self::DEFAULT_TIMEOUT): array
    {
        $response = $this->request($method, $params, $timeout);

        return $response->result;
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

        /** @var RippledResponse $rippledResponse */
        $rippledResponse = $this->serializer->deserialize(
            $response->getContent(),
            RippledResponse::class,
            'json',
        );

        $result = $rippledResponse->result;
        $status = $result['status'] ?? null;

        if ($status === 'error') {
            throw new JsonRpcException("Rippled error: {$result['error_message']}", $response);
        }

        return $rippledResponse;
    }
}
