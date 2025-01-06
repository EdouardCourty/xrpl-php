<?php

declare(strict_types=1);

namespace XRPL\Model\ServerInfo\Nested;

class Reporting
{
    /** @var ETLSource[] $ETLSources */
    public array $ETLSources = [];
    public bool $isWriter;
    public string $lastPublishTime;
}
