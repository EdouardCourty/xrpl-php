<?php

declare(strict_types=1);

namespace XRPL\Tests\Type;

use PHPUnit\Framework\TestCase;
use XRPL\Type\TransactionType;

/**
 * @author Edouard Courty
 *
 * @coversDefaultClass \XRPL\Type\TransactionType
 */
class TransactionTypeTest extends TestCase
{
    /**
     * @covers ::fromString
     */
    public function testWithInvalidTransactionType(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        TransactionType::fromString('InvalidType');
    }

    /**
     * @covers ::fromString
     */
    public function testWithValidTransactionType(): void
    {
        $transactionType = TransactionType::fromString('AccountSet');

        $this->assertEquals('0003', $transactionType->toSerialized());
    }
}
