<?php

declare(strict_types=1);

namespace XRPL\Model\Response;

class Warning
{
    public int $id;
    public string $message;
    public array $details = [];
}
