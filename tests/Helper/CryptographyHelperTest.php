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
}
