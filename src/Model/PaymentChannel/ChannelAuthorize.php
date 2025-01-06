<?php

declare(strict_types=1);

namespace XRPL\Model\PaymentChannel;

use XRPL\Model\AbstractResult;

class ChannelAuthorize extends AbstractResult
{
    public ?string $signature = null;
}
