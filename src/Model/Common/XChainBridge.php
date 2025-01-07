<?php

declare(strict_types=1);

namespace XRPL\Model\Common;

/**
 * @see https://xrpl.org/docs/references/protocol/transactions/types/xchainaccountcreatecommit
 */
class XChainBridge
{
    public string $issuingChainDoor;
    public string $issuingChainIssue;
    public string $lockingChainDoor;
    public string $lockingChainIssue;
}
