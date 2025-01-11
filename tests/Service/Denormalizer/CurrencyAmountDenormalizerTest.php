<?php

declare(strict_types=1);

namespace XRPL\Tests\Service\Denormalizer;

use PHPUnit\Framework\TestCase;
use XRPL\Model\Common\CurrencyAmount;
use XRPL\Service\Denormalizer\CurrencyAmountDenormalizer;

/**
 * @author Edouard Courty <edouard.courty2@gmail.com>
 *
 * @coversDefaultClass \XRPL\Service\Denormalizer\CurrencyAmountDenormalizer
 */
class CurrencyAmountDenormalizerTest extends TestCase
{
    private CurrencyAmountDenormalizer $currencyAmountDenormalizer;

    protected function setUp(): void
    {
        $this->currencyAmountDenormalizer = new CurrencyAmountDenormalizer();
    }

    /**
     * @covers ::denormalize
     */
    public function testItDenormalizesXRPAmount(): void
    {
        $payload = '10000'; // Should be denormalized as a CurrencyAmount

        $currencyAmount = $this->currencyAmountDenormalizer->denormalize($payload, CurrencyAmount::class);

        $this->assertEquals('XRP', $currencyAmount->getCurrency());
        $this->assertEquals('10000', $currencyAmount->getValue());
        $this->assertNull($currencyAmount->getIssuer());
    }

    /**
     * @covers ::denormalize
     */
    public function testItDenormalizesIssuedAmount(): void
    {
        $payload = [
            'currency' => 'USD',
            'value' => '10000',
            'issuer' => 'r9cZA1mLK5R5Am25ArfXFmqgNwjZgnfk59',
        ]; // Should be denormalized as a CurrencyAmount

        $currencyAmount = $this->currencyAmountDenormalizer->denormalize($payload, CurrencyAmount::class);

        $this->assertEquals('USD', $currencyAmount->getCurrency());
        $this->assertEquals('10000', $currencyAmount->getValue());
        $this->assertEquals('r9cZA1mLK5R5Am25ArfXFmqgNwjZgnfk59', $currencyAmount->getIssuer());
    }
}
