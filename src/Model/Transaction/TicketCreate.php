<?php

declare(strict_types=1);

namespace XRPL\Model\Transaction;

use XRPL\Model\AbstractTransaction;

/**
 * https://xrpl.org/ticketcreate.html
 */
class TicketCreate extends AbstractTransaction
{
    public int $ticketCount;
}
