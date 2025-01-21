<?php

declare(strict_types=1);

namespace XRPL\Tests\Type;

use PHPUnit\Framework\TestCase;
use XRPL\Type\Blob;

/**
 * @author Edouard Courty
 *
 * @coversDefaultClass \XRPL\Type\Blob
 */
class BlobTest extends TestCase
{
    /**
     * @covers ::fromJson
     */
    public function testBlob(): void
    {
        $blobData = 'AE4D43231FE6CDF12DC12DA1F32F';
        $blob = Blob::fromJson($blobData);

        $this->assertEquals($blob->toSerialized(), $blobData);
    }

    /**
     * @covers ::fromJson
     */
    public function testWithInvalidData(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        Blob::fromString('not a hex string');
    }
}
