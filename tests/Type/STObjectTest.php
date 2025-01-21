<?php

declare(strict_types=1);

namespace XRPL\Tests\Type;

use PHPUnit\Framework\TestCase;
use XRPL\Type\STObject;

/**
 * @coversDefaultClass \XRPL\Type\STObject
 */
class STObjectTest extends TestCase
{
    /**
     * @covers ::fromJson
     */
    public function testWithoutObjectEndMarker(): void
    {
        $data = [
            'Memo' => [
                'MemoData' => '1111111111',
                'MemoType' => '2222222222',
                'MemoFormat' => '0000000000',
            ],
        ];

        $stObject = STObject::fromJson($data);

        $this->assertEquals('EA7C0522222222227D0511111111117E050000000000E1', $stObject->toSerialized());
    }

    public function testWithObjectEndMarker(): void
    {
        $data = [
            'Memo' => [
                'MemoData' => '1111111111',
                'MemoType' => '2222222222',
                'MemoFormat' => '0000000000',
            ],
            'ObjectEndMarker' => [],
        ];

        $stObject = STObject::fromJson($data);

        $this->assertEquals('E1EA7C0522222222227D0511111111117E050000000000E1', $stObject->toSerialized());
    }
}
