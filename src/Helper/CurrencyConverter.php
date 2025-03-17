<?php

declare(strict_types=1);

namespace XRPL\Helper;

use XRPL\Exception\InvalidCurrencyCodeException;
use XRPL\Type\Currency;

/**
 * @author Edouard Courty
 */
class CurrencyConverter
{
    public static function convert(string $currencyCode): string
    {
        if (mb_strlen($currencyCode) === 3) {
            return (new Currency($currencyCode))->toSerialized();
        }

        if (mb_strlen($currencyCode) > 20) {
            throw InvalidCurrencyCodeException::fromCurrencyCode($currencyCode, 'Currency code cannot be longer than 20 characters.');
        }

        $hexVersion = mb_strtoupper(bin2hex($currencyCode));
        return mb_str_pad($hexVersion, 40, '0');
    }
}
