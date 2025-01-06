<?php

declare(strict_types=1);

namespace XRPL\Model\ServerInfo;

use XRPL\Model\ServerInfo\Nested\LastClose;
use XRPL\Model\ServerInfo\Nested\Load;
use XRPL\Model\ServerInfo\Nested\PortDescriptor;
use XRPL\Model\ServerInfo\Nested\Reporting;
use XRPL\Model\ServerInfo\Nested\ValidatedLedger;

class State
{
    public ?bool $amendmentBlocked = null;
    public string $buildVersion;
    public string $completeLedgers;
    public ?ValidatedLedger $closedLedger = null;
    public int $ioLatencyMs;
    public int|string $jqTransOverflow;
    public LastClose $lastClose;
    public ?Load $load = null;
    public int $loadBase;
    public int $loadFactor;
    public int $loadFactorFeeEscalation;
    public int $loadFactorFeeQueue;
    public int $loadFactorFeeReference;
    public int $loadFactorFeeServer;
    public int $peers;
    /** @var PortDescriptor[] $ports */
    public array $ports = [];
    public string $pubkeyNode;
    public ?string $pubkeyValidator = null;
    public ?Reporting $reporting = null;
    public string $serverState;
    public string $serverStateDurationUs;
    public string $time;
    public int $uptime;
    public ValidatedLedger $validatedLedger;
    public int $validationQuorum;
    public ?int $validatorListExpires = null;
}
