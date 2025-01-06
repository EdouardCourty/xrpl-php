<?php

declare(strict_types=1);

namespace XRPL\Model\ServerInfo\Nested;

class PortDescriptor
{
    public int|string $port;
    /** @var string[] */
    public array $protocol;
}
