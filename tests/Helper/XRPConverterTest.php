<?php

declare(strict_types=1);

namespace XRPL\Tests\Helper;

use PHPUnit\Framework\TestCase;
use XRPL\Helper\XRPConverter;

/**
 * @author Edouard Courty <edouard.courty2@gmail.com>
 *
 * @coversDefaultClass \XRPL\Helper\XRPConverter
 */
class XRPConverterTest extends TestCase
{
    /**
     * @covers ::xrpToDrops
     */
    public function testConvertXrpToDrops(): void
    {
        $xrp = '1.12';
        $drops = '1120000';

        $this->assertSame($drops, XRPConverter::xrpToDrops($xrp));
    }

    /**
     * @covers ::dropsToXrp
     */
    public function testConvertDropsToXrp(): void
    {
        $drops = '1120000';
        $xrp = '1.120000';

        $this->assertSame($xrp, XRPConverter::dropsToXrp($drops));
    }
}
