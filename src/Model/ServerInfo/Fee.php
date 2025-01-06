<?php

declare(strict_types=1);

namespace XRPL\Model\ServerInfo;

use XRPL\Model\AbstractResult;
use XRPL\Model\ServerInfo\Nested\Drops;
use XRPL\Model\ServerInfo\Nested\Levels;

class Fee extends AbstractResult
{
    public string $currentLedgerSize;
    public string $currentQueueSize;
    public Drops $drops;
    public string $expectedLedgerSize;
    public int $ledgerCurrentIndex;
    public Levels $levels;
    public string $maxQueueSize;
}
