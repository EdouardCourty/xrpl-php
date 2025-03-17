<?php

declare(strict_types=1);

namespace XRPL\Tests\Type;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use XRPL\Type\Currency;

/**
 * @author Edouard Courty
 *
 * @coversDefaultClass \XRPL\Type\Currency
 */
class CurrencyTest extends TestCase
{
    public function testCurrencyWithStandardCode(): void
    {
        $currency = new Currency('USD');
        $serialized = $currency->toserialized();

        $this->assertEquals('0000000000000000000000005553440000000000', $serialized);
    }

    public function testCurrencyWithNonStandardCode(): void
    {
        $currency = new Currency('524C555344000000000000000000000000000000');
        $serialized = $currency->toserialized();

        $this->assertEquals('524C555344000000000000000000000000000000', $serialized);
    }

    /**
     * @covers ::fromJson
     */
    #[DataProvider('provideInvalidCurrencies')]
    public function testWithInvalidCurrency(string $currencySymbol): void
    {
        $this->expectException(\InvalidArgumentException::class);

        Currency::fromJson($currencySymbol);
    }

    public static function provideInvalidCurrencies(): iterable
    {
        yield ['US'];
        yield ['USDD'];
        yield ['524C555344000000000000000000000000000'];
    }
}
