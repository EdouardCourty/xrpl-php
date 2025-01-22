<?php

declare(strict_types=1);

namespace XRPL\Tests\Helper;

use PHPUnit\Framework\TestCase;
use XRPL\Helper\Cryptography;

/**
 * @author Edouard Courty
 *
 * @coversDefaultClass \XRPL\Helper\Cryptography
 */
class CryptographyHelperTest extends TestCase
{
    /**
     * @covers ::encodeBase58
     */
    public function testItEncodesStringToBase58(): void
    {
        $encoded = Cryptography::encodeBase58('ecourty');

        $this->assertEquals('hqisqrNPLU', $encoded);
    }

    /**
     * @covers ::encodeBase58
     */
    public function testItDecodesBase58ToString(): void
    {
        $decoded = Cryptography::decodeBase58('hqisqrNPLU');

        $this->assertEquals('ecourty', $decoded);
    }

    /**
     * @covers ::halfSha512
     */
    public function testHalfSHa512(): void
    {
        $value = 'AB12CD34F5';

        $expectedHash = '78E7F547F0A21C78B67CEA78C7B5B22E9E1E102569D780D31F665785553D915E';
        $this->assertEquals($expectedHash, mb_strtoupper(Cryptography::halfSha512((string) hex2bin($value))));
    }
}
