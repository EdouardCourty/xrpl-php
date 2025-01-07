<?php

declare(strict_types=1);

namespace XRPL\Model\Account\Nested;

class Channel
{
    public string $account;
    public string $amount;
    public string $balance;
    public string $channelId;
    public string $destinationAccount;
    public int $settleDelay;
    public ?string $publicKey = null;
    public ?string $publicKeyHex = null;
    public ?int $expiration = null;
    public ?int $cancelAfter = null;
    public ?int $sourceTag = null;
    public ?int $destinationTag = null;
}
