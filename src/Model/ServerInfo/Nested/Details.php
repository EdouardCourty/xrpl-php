<?php

declare(strict_types=1);

namespace XRPL\Model\ServerInfo\Nested;

class Details
{
    public string $domain;
    public string $ephemeralKey;
    public string $masterKey;
    public int $seq;
}
