<?php

declare(strict_types=1);

namespace XRPL\Exception;

/**
 * @author Edouard Courty
 */
class NFTNotFoundException extends \Exception
{
    public static function fromIdentifier(string|int $identifier): self
    {
        return new self(\sprintf('NFT with identifier %s not found', $identifier));
    }
}
