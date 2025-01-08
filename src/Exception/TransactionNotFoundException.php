<?php

declare(strict_types=1);

namespace XRPL\Exception;

class TransactionNotFoundException extends \Exception
{
    public static function fromIdentifier(string|int $identifier): self
    {
        return new self(sprintf('Transaction with identifier %s not found', $identifier));
    }
}
