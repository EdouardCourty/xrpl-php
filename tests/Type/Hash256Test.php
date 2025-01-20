<?php

declare(strict_types=1);

namespace XRPL\Tests\Type;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use XRPL\Type\Hash256;

/**
 * @coversDefaultClass \XRPL\Type\Hash256
 */
class Hash256Test extends TestCase
{
    /**
     * @covers ::__construct
     */
    #[DataProvider('provideInvalidValues')]
    public function testItCannotBeInstantiatedWithInvalidValue(string $value): void
    {
        $this->expectException(\InvalidArgumentException::class);

        new Hash256($value);
    }

    /**
     * @covers ::__construct
     */
    public function testItWorks(): void
    {
        $hash = new Hash256('3070B36F83D424B768DFA77642741766BF5831B3C6A1793A3F45DA68C492068A');

        $this->assertEquals(32, $hash->getLength());
    }

    public static function provideInvalidValues(): iterable
    {
        yield ['String too short'];
        yield ['String toooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooo long'];
    }
}
