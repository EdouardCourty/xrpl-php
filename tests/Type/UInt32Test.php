<?php

declare(strict_types=1);

namespace XRPL\Tests\Type;

use PHPUnit\Framework\TestCase;
use XRPL\Type\UInt32;

/**
 * @author Edouard Courty
 *
 * @coversDefaultClass \XRPL\Type\UInt32
 */
class UInt32Test extends TestCase
{
    /**
     * @covers ::fromJson
     * @covers ::toInt
     */
    public function testUInt32(): void
    {
        $uint8 = UInt32::fromJson(123456);
        $this->assertEquals(123456, $uint8->toInt());
        $this->assertEquals('0001E240', $uint8->toSerialized());
    }

    public function testOutOfRange(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        UInt32::fromJson(4294967296); // Uint32 can only be 0-4294967295
    }
}
