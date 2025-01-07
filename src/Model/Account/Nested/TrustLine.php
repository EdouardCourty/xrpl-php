<?php

declare(strict_types=1);

namespace XRPL\Model\Account\Nested;

class TrustLine
{
    public string $account;
    public string $balance;
    public string $currency;
    public string $limit;
    public string $limitPeer;
    public int $qualityIn;
    public int $qualityOut;
    public ?bool $noRipple = null;
    public ?bool $noRipplePeer = null;
    public ?bool $authorized = null;
    public ?bool $peerAuthorized = null;
    public ?bool $freeze = null;
    public ?bool $freezePeer = null;
}
