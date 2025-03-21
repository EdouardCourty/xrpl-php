<?php

declare(strict_types=1);

namespace XRPL\Exception;

use Symfony\Contracts\HttpClient\ResponseInterface;
use Throwable;

/**
 * @author Edouard Courty
 *
 * @codeCoverageIgnore
 */
class JsonRpcException extends \Exception
{
    public function __construct(
        string $message,
        private readonly ?ResponseInterface $response = null,
        ?Throwable $previous = null,
    ) {
        parent::__construct($message, $this->response?->getStatusCode() ?? 0, $previous);
    }

    public function getResponse(): ?ResponseInterface
    {
        return $this->response;
    }
}
