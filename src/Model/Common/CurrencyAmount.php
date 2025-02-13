<?php

declare(strict_types=1);

namespace XRPL\Model\Common;

/**
 * Represents a currency amount in the XRP Ledger.
 * As amounts can have two different formats, this class is used to represent both.
 *
 * @see https://xrpl.org/docs/references/protocol/data-types/basic-data-types#specifying-currency-amounts
 *
 * @author Edouard Courty
 */
class CurrencyAmount
{
    private const string DEFAULT_CURRENCY = 'XRP';

    private ?string $xrpDrops = null;

    private string $currency;
    private ?string $issuer = null;
    private ?string $value = null;

    public static function fromXRP(string $drops): self
    {
        $instance = new self();
        $instance->xrpDrops = $drops;
        $instance->currency = self::DEFAULT_CURRENCY;

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
        return $this->issuer !== null;
    }

    public function __toString(): string
    {
        return $this->getValue();
    }

    public function getValue(): string
    {
        if ($this->isXRP() === true && $this->xrpDrops === null) {
            throw new \UnexpectedValueException('XRP drops value is not set');
        }
        if ($this->isXRP() === false && $this->value === null) {
            throw new \UnexpectedValueException('Value is not set');
        }

        return $this->isXRP() ? (string) $this->xrpDrops : (string) $this->value;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getIssuer(): ?string
    {
        return $this->issuer;
    }
}
