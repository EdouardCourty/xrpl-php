<?php

declare(strict_types=1);

namespace XRPL\Type;

/**
 * @author Edouard Courty
 */
class STIssue extends AbstractBinaryType
{
    public function __construct(
        Currency $currency,
        AccountID $issuer,
    ) {
        parent::__construct(array_merge($currency->getBytes(), $issuer->getBytes()));
    }

    public static function fromJson(mixed $data): static
    {
        if (\is_array($data) === false) {
            throw new \InvalidArgumentException('STIssue must be an array');
        }

        if (isset($data['currency']) === false) {
            throw new \InvalidArgumentException('STIssue must have a currency');
        }

        if (isset($data['issuer']) === false) {
            throw new \InvalidArgumentException('STIssue must have an issuer');
        }

        return new static(
            Currency::fromJson($data['currency']),
            AccountID::fromJson($data['issuer']),
        );
    }
}
