<?php

declare(strict_types=1);

namespace XRPL\Tests\Type;

use PHPUnit\Framework\TestCase;
use XRPL\Type\UInt8;

/**
 * @author Edouard Courty
 *
 * @coversDefaultClass \XRPL\Type\UInt8
 */
class UInt8Test extends TestCase
{
    /**
     * @covers ::fromJson
     * @covers ::toInt
     */
    public function testUInt8(): void
    {
        $uint8 = UInt8::fromJson(10);
        $this->assertEquals(10, $uint8->toInt());
        $this->assertEquals('0A', $uint8->toSerialized());
    }

    public function testOutOfRange(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        UInt8::fromJson(256); // Uint8 can only be 0-255
    }
}
