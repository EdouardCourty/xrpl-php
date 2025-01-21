<?php

declare(strict_types=1);

namespace XRPL\Tests\Type;

use PHPUnit\Framework\TestCase;
use XRPL\Type\Hash256;

/**
 * @author Edouard Courty
 *
 * @coversDefaultClass \XRPL\Type\Hash256
 */
class Hash256Test extends TestCase
{
    /**
     * @covers ::fromJson
     */
    public function testWithInputTooLong(): void
    {
        $hash = 'FE23AF2E3AF2D45AFE23AF2E3AF2D45AFE23AF2E3AF2D45AD45AD45AD45AD45AD45AD45A'; // 72 Length
        $this->expectException(\InvalidArgumentException::class);

        Hash256::fromJson($hash);
    }

    /**
     * @covers ::fromJson
     */
    public function testWithInputTooShort(): void
    {
        $hash = 'FE23AF2E3AF2D45A'; // 16 Length
        $this->expectException(\InvalidArgumentException::class);

        Hash256::fromJson($hash);
    }

    /**
     * @covers ::fromJson
     */
    public function testWithValueCorrectLength(): void
    {
        $hash = 'FE23AF2E3AF2D45AFE23AF2E3AF2D45AD45AD45AD45AD45AD45AD45AD45AD45A'; // 64 Length
        $hashObject = Hash256::fromJson($hash);

        $this->assertEquals($hashObject->toSerialized(), $hash);
    }
}
