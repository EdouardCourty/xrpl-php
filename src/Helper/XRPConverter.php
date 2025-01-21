<?php

declare(strict_types=1);

namespace XRPL\Helper;

/**
 * @author Edouard Courty
 */
class XRPConverter
{
    private const string XRP_DROPS_MULTIPLIER = '1000000';

    /**
     * Convert an amount in XRP.
     *
     * 1 XRP = 1,000,000 drops
     *
     * @return numeric-string
     */
    public static function xrpToDrops(string $xrp): string
    {
        if (!is_numeric($xrp)) {
            throw new \InvalidArgumentException('The XRP amount must be numeric.');
        }

        return bcmul($xrp, self::XRP_DROPS_MULTIPLIER, 0);
    }

    /**
     * Convert an amount in drops to XRP.
     *
     * 1 XRP = 1,000,000 drops
     *
     * @return numeric-string
     */
    public static function dropsToXrp(string $drops): string
    {
        // Validate input
        if (!is_numeric($drops)) {
            throw new \InvalidArgumentException('The drops amount must be numeric.');
        }

        return bcdiv($drops, self::XRP_DROPS_MULTIPLIER, 6);
    }
}
