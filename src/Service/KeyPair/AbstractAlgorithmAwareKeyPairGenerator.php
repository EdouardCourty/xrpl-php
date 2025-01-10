<?php

declare(strict_types=1);

namespace XRPL\Service\KeyPair;

use XRPL\ValueObject\KeyPair;
use XRPL\ValueObject\Seed;
use XRPL\ValueObject\Wallet;

/**
 * @author Edouard Courty <edouard.courty2@gmail.com>
 */
abstract class AbstractAlgorithmAwareKeyPairGenerator
{
    protected const string PREFIX_ED25519 = 'ED';
    protected const STRING PREFIX_SECP256K1 = '00';

    public const array PREFIX_MAPPING = [
        Wallet::ALGORITHM_ED25519 => self::PREFIX_ED25519,
        Wallet::ALGORITHM_SECP256K1 => self::PREFIX_SECP256K1,
    ];

    public abstract function deriveKeyPair(Seed $seed, bool $validator = false, int $index = 0): KeyPair;
}
