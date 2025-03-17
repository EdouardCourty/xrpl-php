<?php

declare(strict_types=1);

namespace XRPL\Tests\Helper;

use PHPUnit\Framework\TestCase;
use XRPL\Helper\CurrencyConverter;

/**
 * @author Edouard Courty
 *
 * @coversDefaultClass \XRPL\Helper\CurrencyConverter
 */
class CurrencyConverterTest extends TestCase
{
    /**
     * @covers ::convert
     *
     * @dataProvider provideValidCodes
     */
    public function testConvertWithStandardCode(string $currencyCode, string $expectedOutput): void
    {
        $converted = CurrencyConverter::convert($currencyCode);

        $this->assertEquals($expectedOutput, $converted);
    }

    public static function provideValidCodes(): \Generator
    {
        yield ['XRP', '0000000000000000000000005852500000000000'];
        yield ['RLUSD', '524C555344000000000000000000000000000000'];
        yield ['SOLO', '534F4C4F00000000000000000000000000000000'];
    }
}
