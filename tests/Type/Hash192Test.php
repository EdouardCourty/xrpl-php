<?php

declare(strict_types=1);

namespace XRPL\Tests\Type;

use PHPUnit\Framework\TestCase;
use XRPL\Type\Hash192;

/**
 * @coversDefaultClass \XRPL\Type\Hash192
 */
class Hash192Test extends TestCase
{
    /**
     * @covers ::fromJson
     */
    public function testWithInputTooLong(): void
    {
        $hash = 'FE23AF2E3AF2D45AFE23AF2E3AF2D45AFE23AF2E3AF2D45AD45AD45A'; // 56 Length
        $this->expectException(\InvalidArgumentException::class);

        Hash192::fromJson($hash);
    }

    /**
     * @covers ::fromJson
     */
    public function testWithInputTooShort(): void
    {
        $hash = 'FE23AF2E3AF2D45A'; // 16 Length
        $this->expectException(\InvalidArgumentException::class);

        Hash192::fromJson($hash);
    }

    /**
     * @covers ::fromJson
     */
    public function testWithValueCorrectLength(): void
    {
        $hash = 'FE23AF2E3AF2D45AFE23AF2E3AF2D45AD45AD45AD45AD45A'; // 48 Length
        $hashObject = Hash192::fromJson($hash);

        $this->assertEquals($hashObject->toSerialized(), $hash);
    }
}
