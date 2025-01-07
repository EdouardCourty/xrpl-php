<?php

declare(strict_types=1);

namespace XRPL\Model\Transaction;

use Symfony\Component\Serializer\Attribute\SerializedName;
use XRPL\Model\AbstractTransaction;

/**
 * @see https://xrpl.org/diddelete.html
 */
class DIDSet extends AbstractTransaction
{
    public ?string $data = null;
    #[SerializedName('DIDDocument')]
    public ?string $DIDDocument = null;
    #[SerializedName('URI')]
    public ?string $uri = null;
}
