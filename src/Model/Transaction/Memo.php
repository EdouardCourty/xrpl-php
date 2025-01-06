<?php

declare(strict_types=1);

namespace XRPL\Model\Transaction;

/**
 * @see https://xrpl.org/docs/references/protocol/transactions/common-fields#memos-field
 */
class Memo
{
    public MemoData $memo;
}
