<?php

declare(strict_types=1);

namespace XRPL\Model\ServerInfo;

use XRPL\Model\AbstractResult;

class ServerDefinitions extends AbstractResult
{
    public array $fields = [];
    /** @var array<string, int> */
    public array $ledgerEntryTypes = [];
    /** @var array<string, int> */
    public array $transactionResults = [];
    /** @var array<string, int> */
    public array $transactionTypes = [];
    /** @var array<string, int> */
    public array $types = [];
    public string $hash;
}
