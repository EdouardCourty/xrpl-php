<?php

declare(strict_types=1);

namespace XRPL\Utils;

/**
 * @author Edouard Courty
 */
class SignaturePrefix
{
    public const int TRANSACTION = 0x54584e00; // TXN
    public const int TRANSACTION_NODE = 0x534e4400; // TND
    public const int INNER_NODE = 0x4d494e00; // MIN
    public const int LEAF_NODE = 0x4d4c4e00; // MLN
    public const int TRANSACTION_SIGN = 0x53545800; // STX
    public const int TRANSACTION_SIGN_TESTNET = 0x73747800; // STX
    public const int TRANSACTION_MULTISIGN = 0x534d5400; // SMT
    public const int LEDGER = 0x4c575200; // LWR
}
