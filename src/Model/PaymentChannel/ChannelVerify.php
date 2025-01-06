<?php

declare(strict_types=1);

namespace XRPL\Model\PaymentChannel;

use XRPL\Model\AbstractResult;

class ChannelVerify extends AbstractResult
{
    public bool $signatureVerified = false;
}
