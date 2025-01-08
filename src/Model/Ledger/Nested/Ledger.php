<?php

declare(strict_types=1);

namespace XRPL\Model\Ledger\Nested;

use Symfony\Component\Serializer\Attribute\Ignore;
use XRPL\Model\AbstractTransaction;

/**
 * @author Edouard Courty <edouard.courty2@gmail.com>
 */
class Ledger
{
    public string $accountHash;
    public int $closeFlags;
    public int $closeTime;
    public string $closeTimeHuman;
    public int $closeTimeResolution;
    public string $closeTimeIso;
    public string $ledgerHash;
    public int $parentLedgerTime;
    public string $parentHash;
    public string $totalCoins;
    public string $transactionHash;
    public string $ledgerIndex;
    public bool $closed;

    /** @var string[] $transactionIds */
    #[Ignore]
    public array $transactionIds = [];

    /** @var AbstractTransaction[] $transactions */
    public array $transactions = [];
}
