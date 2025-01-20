<?php

declare(strict_types=1);

namespace XRPL\Tests\Type;

use PHPUnit\Framework\TestCase;
use XRPL\Type\PathSet;

/**
 * @coversDefaultClass \XRPL\Type\PathSet
 */
class PathSetTest extends TestCase
{
    public function testPathSet(): void
    {
        $data = [
            [
                [
                    'currency' => 'USD',
                    'issuer' => 'rhub8VRN55s94qWKDv6jmDy1pUykJzF3wq',
                    'account' => 'rNuaFncML9vq15nzEZd828h3K7x9ipN3xj',
                ],
                [
                    'currency' => 'XRP',
                    'issuer' => 'rhub8VRN55s94qWKDv6jmDy1pUykJzF3wq',
                ],
                [
                    'currency' => 'BTC',
                ],
            ],
            [
                [
                    'currency' => 'XRP',
                    'issuer' => 'rhub8VRN55s94qWKDv6jmDy1pUykJzF3wq',
                ],
            ],
            [
                [
                    'currency' => 'USD',
                    'issuer' => 'rhub8VRN55s94qWKDv6jmDy1pUykJzF3wq',
                    'account' => 'rNuaFncML9vq15nzEZd828h3K7x9ipN3xj',
                ],
                [
                    'currency' => 'XRP',
                    'issuer' => 'rhub8VRN55s94qWKDv6jmDy1pUykJzF3wq',
                ],
            ],
        ];

        $pathSet = PathSet::fromJson($data);

        $this->assertEquals(
            '3198741DD80730B0E3F993BE2D4C5090EF7EB2D11200000000000000000000000055534400000000002ADB0B3959D60A6E6991F729E1918B71639252303000000000000000000000000000000000000000002ADB0B3959D60A6E6991F729E1918B7163925230100000000000000000000000004254430000000000FF3000000000000000000000000000000000000000002ADB0B3959D60A6E6991F729E1918B7163925230FF3198741DD80730B0E3F993BE2D4C5090EF7EB2D11200000000000000000000000055534400000000002ADB0B3959D60A6E6991F729E1918B71639252303000000000000000000000000000000000000000002ADB0B3959D60A6E6991F729E1918B716392523000',
            $pathSet->toSerialized(),
        );
    }
}
