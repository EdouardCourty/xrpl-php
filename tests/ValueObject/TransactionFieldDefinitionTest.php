<?php

declare(strict_types=1);

namespace XRPL\Tests\ValueObject;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use XRPL\Service\Signature\ServerDefinitions;

/**
 * @author Edouard Courty
 *
 * @coversDefaultClass \XRPL\ValueObject\TransactionFieldDefinition
 */
class TransactionFieldDefinitionTest extends TestCase
{
    #[DataProvider('provideFieldIdTestData')]
    public function testFieldId(
        string $fieldName,
        int $expectedFieldId,
    ): void {
        $fieldInstance = ServerDefinitions::getInstance()->getFieldDefinition($fieldName);

        $this->assertEquals($fieldInstance->getFieldId(), [$expectedFieldId]);
    }

    public static function provideFieldIdTestData(): iterable
    {
        yield [
            'Memo',
            0xea,
        ];

        yield [
            'MemoData',
            0x7d,
        ];

        yield [
            'SignerEntry',
            0xeb,
        ];
    }
}
