<?php

declare(strict_types=1);

namespace XRPL\Model\Transaction;

use XRPL\Model\AbstractTransaction;
use XRPL\Model\Common\SignerEntry;

/**
 * https://xrpl.org/signerlistset.html
 */
class SignerListSet extends AbstractTransaction
{
    public int $signerQuorum;
    /** @var SignerEntry[] $signerEntries */
    public array $signerEntries = [];
}
