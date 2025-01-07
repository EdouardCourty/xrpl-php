<?php

declare(strict_types=1);

namespace XRPL\Model\Response;

class RippledResponse
{
    public mixed $result;
    /** @var Warning[] $warnings */
    public array $warnings = [];
}
