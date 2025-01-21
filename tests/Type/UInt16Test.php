<?php

declare(strict_types=1);

namespace XRPL\Tests\Type;

use PHPUnit\Framework\TestCase;
use XRPL\Type\UInt16;

/**
 * @author Edouard Courty
 *
 * @coversDefaultClass \XRPL\Type\UInt16
 */
class UInt16Test extends TestCase
{
    /**
     * @covers ::fromJson
     * @covers ::toInt
     */
    public function testUInt16(): void
    {
        $uint8 = UInt16::fromJson(4600);
        $this->assertEquals(4600, $uint8->toInt());
        $this->assertEquals('11F8', $uint8->toSerialized());
    }

    public function testOutOfRange(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        UInt16::fromJson(65536); // Uint16 can only be 0-65535
    }
}
