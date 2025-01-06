<?php

declare(strict_types=1);

namespace XRPL\Model\ServerInfo;

use XRPL\Model\AbstractResult;
use XRPL\Model\ServerInfo\Nested\Details;

class Manifest extends AbstractResult
{
    public ?Details $details = null;
    public ?string $manifest = null;
    public string $requested;
}
