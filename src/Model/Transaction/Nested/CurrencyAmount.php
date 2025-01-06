<?php

declare(strict_types=1);

namespace XRPL\Model\Transaction\Nested;

/**
 * Represents a currency amount in the XRP Ledger.
 * As amounts can have two different formats, this class is used to represent both.
 *
 * @see https://xrpl.org/docs/references/protocol/data-types/basic-data-types#specifying-currency-amounts
 *
 * @author Edouard Courty <edouard.courty2@gmail.com>
 */
class CurrencyAmount
{
    private ?string $xrpDrops = null;

    private ?string $currency = null;
    private ?string $issuer = null;
    private ?string $value = null;

    public static function fromXRP(string $drops): self
    {
        $instance = new self();
        $instance->xrpDrops = $drops;

        return $instance;
    }

    public static function fromIssued(string $currency, string $value, string $issuer): self
    {
        $instance = new self();
        $instance->currency = $currency;
        $instance->value = $value;
        $instance->issuer = $issuer;

        return $instance;
    }

    public function isXRP(): bool
    {
        return $this->xrpDrops !== null;
    }

    public function isIssued(): bool
    {
        return $this->currency !== null;
    }

    public function getValue(): string
    {
        return $this->isXRP() ? $this->xrpDrops : $this->value;
    }

    public function getCurrency(): string
    {
        return $this->isXRP() ? 'XRP' : $this->currency;
    }

    public function getIssuer(): ?string
    {
        return $this->issuer;
    }
}
