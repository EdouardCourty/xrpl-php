<?php

declare(strict_types=1);

namespace XRPL\Model\Account\Nested;

use Symfony\Component\Serializer\Attribute\SerializedName;

class AccountFlags
{
    public ?bool $defaultRipple = null;
    public ?bool $depositAuth = null;
    public ?bool $disableMasterKey = null;
    public ?bool $disallowIncomingCheck = null;
    public ?bool $disallowIncomingNFTokenOffer = null;
    public ?bool $disallowIncomingPayChan = null;
    public ?bool $disallowIncomingTrustline = null;
    public ?bool $disallowIncomingXRP = null;
    public ?bool $globalFreeze = null;
    public ?bool $noFreeze = null;
    public ?bool $passwordSpent = null;
    public ?bool $requireAuthorization = null;
    public ?bool $requireDestinationTag = null;
}
