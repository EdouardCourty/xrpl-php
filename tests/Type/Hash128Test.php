<?php

declare(strict_types=1);

namespace XRPL\Tests\Type;

use PHPUnit\Framework\TestCase;
use XRPL\Type\Hash128;

/**
 * @author Edouard Courty
 *
 * @coversDefaultClass \XRPL\Type\Hash128
 */
class Hash128Test extends TestCase
{
    /**
     * @covers ::fromJson
     */
    public function testWithInputTooLong(): void
    {
        $hash = 'FE23AF2E3AF2D45AFE23AF2E3AF2D45AFE23AF2E3AF2D45A'; // 48 Length
        $this->expectException(\InvalidArgumentException::class);

        Hash128::fromJson($hash);
    }

    /**
     * @covers ::fromJson
     */
    public function testWithInputTooShort(): void
    {
        $hash = 'FE23AF2E3AF2D45A'; // 16 Length
        $this->expectException(\InvalidArgumentException::class);

        Hash128::fromJson($hash);
    }

    /**
     * @covers ::fromJson
     */
    public function testWithValueCorrectLength(): void
    {
        $hash = 'FE23AF2E3AF2D45AFE23AF2E3AF2D45A'; // 32 Length
        $hashObject = Hash128::fromJson($hash);

        $this->assertEquals($hashObject->toSerialized(), $hash);
    }
}
