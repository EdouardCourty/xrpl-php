<?php

declare(strict_types=1);

namespace XRPL\Model\Account\Nested;

use Symfony\Component\Serializer\Attribute\SerializedPath;
use XRPL\Model\AbstractTransaction;
use XRPL\Model\Transaction\TransactionMetadata;

class AccountTransaction
{
    public TransactionMetadata $meta;
    #[SerializedPath('[tx]')]
    public AbstractTransaction $transaction;
}
