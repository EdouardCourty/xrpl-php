<?php

declare(strict_types=1);

namespace XRPL\Tests\Type;

use PHPUnit\Framework\TestCase;
use XRPL\Type\Amount;

/**
 * @coversDefaultClass \XRPL\Type\Amount
 */
class AmountTest extends TestCase
{
    public function testXRPAmount(): void
    {
        $amount = new Amount('1000056');
        $serialized = $amount->toSerialized();

        $this->assertEquals('40000000000F4278', $serialized);
    }

    public function testIssuedAmount(): void
    {
        $amount = new Amount('153.85', 'USD', 'r9cZA1mLK5R5Am25ArfXFmqgNwjZgnfk59');
        $serialized = $amount->toSerialized();

        $this->assertEquals('D5057741F1FCA80000000000000000000000000055534400000000005E7B112523F68D2F5E879DB4EAC51C6698A69304', $serialized);
    }
}
