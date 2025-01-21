<?php

declare(strict_types=1);

namespace XRPL\ValueObject;

use XRPL\Helper\Cryptography;

/**
 * @author Edouard Courty
 */
readonly class Seed
{
    public function __construct(
        public string $algorithm,
        #[\SensitiveParameter]
        public array $prefix,
        #[\SensitiveParameter]
        public array $payload,
        #[\SensitiveParameter]
        public array $checksum,
    ) {
    }

    public function isValid(): bool
    {
        $check = Cryptography::doubleSha256(
            Cryptography::byteArrayToString(
                array_merge($this->prefix, $this->payload),
            ),
        );

        $checkBytes = Cryptography::byteStringToArray($check);
        $checkSum = \array_slice($checkBytes, 0, 4);

        return $checkSum === $this->checksum;
    }

    public function __toString(): string
    {
        return $this->toString();
    }

    public function toString(): string
    {
        return Cryptography::encodeBase58(
            Cryptography::byteArrayToString(
                array_merge($this->prefix, $this->payload, $this->checksum),
            ),
        );
    }
}
