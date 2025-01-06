<?php

namespace XRPL\Model\Transaction;

use XRPL\Model\AbstractTransaction;

/**
 * @see https://xrpl.org/diddelete.html
 */
class DIDSet extends AbstractTransaction
{
    public ?string $data = null;
    public ?string $DIDDocument = null;
    public ?string $uri = null;
}
