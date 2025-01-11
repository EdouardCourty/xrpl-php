<?php

declare(strict_types=1);

namespace XRPL\Tests\Utils;

use PHPUnit\Framework\TestCase;
use XRPL\Utils\JsonRpcRequest;

/**
 * @author Edouard Courty <edouard.courty2@gmail.com>
 *
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
