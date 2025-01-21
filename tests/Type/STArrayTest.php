<?php

declare(strict_types=1);

namespace XRPL\Tests\Type;

use PHPUnit\Framework\TestCase;
use XRPL\Type\STArray;

/**
 * @author Edouard Courty
 *
 * @coversDefaultClass \XRPL\Type\STArray
 */
class STArrayTest extends TestCase
{
    /**
     * @covers ::fromJson
     */
    public function testSTArray(): void
    {
        $array = [
            [
                'Memo' => [
                    'MemoData' => '1111111111',
                ],
            ],
            [
                'Memo' => [
                    'MemoData' => '2222222222',
                ],
            ],
            [
                'Memo' => [
                    'MemoData' => '0000000000',
                    'MemoFormat' => '3333333333',
                ],
            ],
        ];

        $STArray = STArray::fromJson($array);

        $this->assertEquals('EA7D051111111111E1EA7D052222222222E1EA7D0500000000007E053333333333E1F1', $STArray->toSerialized());
    }
}
