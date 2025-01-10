<?php

declare(strict_types=1);

namespace XRPL\Model\ServerInfo;

use Symfony\Component\Serializer\Attribute\SerializedPath;
use XRPL\Model\AbstractResult;

class ServerDefinitions extends AbstractResult
{
    #[SerializedPath('[FIELDS]')]
    public array $fields = [];
    /** @var array<string, int> */
    #[SerializedPath('[LEDGER_ENTRY_TYPES]')]
    public array $ledgerEntryTypes = [];
    /** @var array<string, int> */
    #[SerializedPath('[TRANSACTION_RESULTS]')]
    public array $transactionResults = [];
    /** @var array<string, int> */
    #[SerializedPath('[TRANSACTION_TYPES]')]
    public array $transactionTypes = [];
    /** @var array<string, int> */
    public array $types = [];
    public string $hash;
}
