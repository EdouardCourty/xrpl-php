<?php

declare(strict_types=1);

namespace Model;

use PHPUnit\Framework\TestCase;
use XRPL\Utils\JsonRpcRequest;

/**
 * @coversDefaultClass  \XRPL\Utils\JsonRpcRequest
 */
class JsonRpcRequestTest extends TestCase
{
    /**
     * @covers ::toArray
     */
    public function testRemovesNullParameters(): void
    {
        $params = [
            'foo' => 'bar',
            'baz' => null,
        ];

        $jsonRpcRequest = new JsonRpcRequest('1', 'method', $params);

        $expectedParams = [
            'foo' => 'bar',
        ];

        $this->assertSame($expectedParams, $jsonRpcRequest->toArray()['params'][0]);
    }
}
