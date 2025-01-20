<?php

declare(strict_types=1);

namespace XRPL\Tests\Type;

use PHPUnit\Framework\TestCase;
use XRPL\Type\AccountID;
use XRPL\Type\Currency;
use XRPL\Type\STIssue;
use XRPL\Type\XChainBridge;

/**
 * @coversDefaultClass \XRPL\Type\XChainBridge
 */
class XChainBridgeTest extends TestCase
{
    public function testXChainBridge(): void
    {
        $xChainBridge = new XChainBridge(
            new AccountID('r9cZA1mLK5R5Am25ArfXFmqgNwjZgnfk59'),
            new STIssue(
                new Currency('USD'),
                new AccountID('rsoLo2S1kiGeCcn6hCUXVrCpGMWLrRrLZz'),
            ),
            new AccountID('r9cZA1mLK5R5Am25ArfXFmqgNwjZgnfk59'),
            new STIssue(
                new Currency('USD'),
                new AccountID('rsoLo2S1kiGeCcn6hCUXVrCpGMWLrRrLZz'),
            ),
        );

        $this->assertEquals(
            '145E7B112523F68D2F5E879DB4EAC51C6698A6930400000000000000000000000055534400000000001EB3EAA3AD86242E1D51DC502DD6566BD39E06A6145E7B112523F68D2F5E879DB4EAC51C6698A6930400000000000000000000000055534400000000001EB3EAA3AD86242E1D51DC502DD6566BD39E06A6',
            $xChainBridge->toSerialized(),
        );
    }
}
