<?php

declare(strict_types=1);

namespace XRPL\Exception;

use Throwable;

/**
 * @author Edouard Courty
 */
class InvalidSeedException extends \Exception
{
    public function __construct(?string $message = null, int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message ?? 'Invalid seed.', $code, $previous);
    }
}
