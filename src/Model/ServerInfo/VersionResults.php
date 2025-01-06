<?php

declare(strict_types=1);

namespace XRPL\Model\ServerInfo;

use XRPL\Model\AbstractResult;
use XRPL\Model\ServerInfo\Nested\Version;

class VersionResults extends AbstractResult
{
    public Version $version;
}
