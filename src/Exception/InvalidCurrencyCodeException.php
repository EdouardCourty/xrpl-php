<?php

declare(strict_types=1);

namespace XRPL\Exception;

class InvalidCurrencyCodeException extends \Exception
{
    public static function fromCurrencyCode(string $currencyCode, string $reason = 'Invalid code.'): self
    {
        return new self(\sprintf('Currency code "%s" is invalid. Reason: %s', $currencyCode, $reason));
    }
}
