<?php

declare(strict_types=1);

namespace XRPL\Service\KeyPair;

use XRPL\Contract\KeyPairInterface;
use XRPL\Enum\Algorithm;
use XRPL\ValueObject\Seed;

/**
 * @author Edouard Courty
 */
abstract class AbstractAlgorithmAwareKeyPairGenerator
{
    abstract public function deriveKeyPair(Seed $seed, bool $validator = false, int $index = 0): KeyPairInterface;

    abstract public function sign(string $message, string $privateKey): string;

    abstract public static function getAlgorithm(): Algorithm;
}
