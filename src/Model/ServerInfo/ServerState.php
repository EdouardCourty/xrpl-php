<?php

declare(strict_types=1);

namespace XRPL\Model\ServerInfo;

use XRPL\Model\AbstractResult;

class ServerState extends AbstractResult
{
    public State $state;
}
