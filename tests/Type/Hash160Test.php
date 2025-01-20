<?php

declare(strict_types=1);

namespace XRPL\Tests\Type;

use PHPUnit\Framework\TestCase;
use XRPL\Type\Hash160;

/**
 * @coversDefaultClass \XRPL\Type\Hash160
 */
class Hash160Test extends TestCase
{
    /**
     * @covers ::fromJson
     */
    public function testWithInputTooLong(): void
    {
        $hash = 'FE23AF2E3AF2D45AFE23AF2E3AF2D45AFE23AF2E3AF2D45A'; // 48 Length
        $this->expectException(\InvalidArgumentException::class);

        Hash160::fromJson($hash);
    }

    /**
     * @covers ::fromJson
     */
    public function testWithInputTooShort(): void
    {
        $hash = 'FE23AF2E3AF2D45A'; // 16 Length
        $this->expectException(\InvalidArgumentException::class);

        Hash160::fromJson($hash);
    }

    /**
     * @covers ::fromJson
     */
    public function testWithValueCorrectLength(): void
    {
        $hash = 'FE23AF2E3AF2D45AFE23AF2E3AF2D45AD45AD45A'; // 40 Length
        $hashObject = Hash160::fromJson($hash);

        $this->assertEquals($hashObject->toSerialized(), $hash);
    }
}
