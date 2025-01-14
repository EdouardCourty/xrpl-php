<?php

declare(strict_types=1);

namespace XRPL\ValueObject;

use XRPL\Enum\TransactionTypeEnum;
use XRPL\Service\Signature\Signer;

class Transaction
{
    public function __construct(
        private string $account,
        private TransactionTypeEnum $transactionType,
        private string $fee,
        private int $sequence,
        private string $signingPubKey,
        private string $accountTxnId,
        private ?int $flags = null,
        private array $memos = [],
    ) {
    }

    public function sign(Wallet $wallet): self
    {
        $signature = Signer::signTransaction($this, null);
    }

    public function toArray(): array
    {
        return [
            'Account' => $this->account,
            'TransactionType' => $this->transactionType,
            'Fee' => $this->fee,
            'Sequence' => $this->sequence,
            'SigningPubKey' => $this->signingPubKey,
            'AccountTxnId' => $this->accountTxnId,
            'Flags' => $this->flags,
            'Memos' => $this->memos,
        ];
    }
}
