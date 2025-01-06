<?php

declare(strict_types=1);

namespace XRPL\Model\ServerInfo\Nested;

class ETLSource
{
    public bool $connected;
    public string $grpcPort;
    public string $ip;
    public string $lastMessageArrivalTime;
    public string $validatedLedgersRange;
    public string $websocketPort;
}
