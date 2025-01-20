<?php

declare(strict_types=1);

namespace XRPL\Type;

use InvalidArgumentException;

class Amount extends AbstractBinaryType
{
    private const string CURRENCY_XRP = 'XRP';

    public string $value;
    public ?string $currency = null;
    public ?string $issuer = null;

    public function __construct(string $value, ?string $currency = null, ?string $issuer = null)
    {
        $isIssued = $currency !== null && $issuer !== null;
        $this->value = $value;
        $this->currency = $currency;
        $this->issuer = $issuer;

        $bytes = $isIssued ? $this->getIssuedBytes($value, $currency, $issuer) : $this->getXRPBytes($value);

        parent::__construct($bytes);
    }

    private function getXRPBytes(string $amount): array
    {
        $drops = gmp_init($amount, 10);

        if (gmp_sign($drops) < 0) {
            throw new InvalidArgumentException('XRP amount cannot be negative.');
        }

        // 0x4000000000000000 = second MSB set to 1, MSB = 0 (XRP indicator)
        $mask = gmp_init('4000000000000000', 16);
        $value = gmp_or($drops, $mask);

        // Convert to zero-padded 16-hex-character string (8 bytes)
        $hex = gmp_strval($value, 16);
        $hex = str_pad($hex, 16, '0', STR_PAD_LEFT);

        $binary = pack('H*', $hex);  // 8 bytes

        // Unpack that binary string to an array of bytes (C* = unsigned char)
        $bytes = unpack('C*', $binary);

        if ($bytes === false) {
            throw new InvalidArgumentException('Failed to unpack XRP amount.');
        }

        // Return array_values(...) to reindex from 0..7
        return array_values($bytes);
    }


    private function getIssuedBytes(string $amount, string $currency, string $issuer): array
    {
        $currencyBytes = (new Currency($currency))->getBytes();
        $tokenAmount = $this->encodeTokenAmount($amount);
        $issuerBytes = (new AccountID($issuer))->getBytes();

        return array_merge($tokenAmount, $currencyBytes, $issuerBytes);
    }

    /**
     * Encode a fungible token amount (non-XRP) into 8 bytes (64 bits),
     * following the XRP Ledger serialization rules.
     *
     * @param string $amount A decimal string (e.g. "123.45", "-0.00000123", "0", etc.)
     * @throws InvalidArgumentException if the amount cannot be represented
     * @return int[] Array of 8 unsigned bytes in big-endian order
     */
    function encodeTokenAmount(string $amount): array
    {
        $amount = trim($amount);
        if ($amount === '') {
            throw new InvalidArgumentException('Amount cannot be empty.');
        }

        // -------------------------------------------------------------------------
        // Special case: Amount = 0 => 0x8000000000000000
        // -------------------------------------------------------------------------
        // We'll parse the amount numerically. If it's exactly zero, return that.
        $isNegative = str_starts_with($amount, '-');
        $unsignedStr = ltrim($amount, '+-');

        // Use BC or GMP. Here, we'll use BCMath for clarity:
        if (!bccomp($unsignedStr, '0', 100)) { // @phpstan-ignore-line
            // Exactly zero
            // 0x8000000000000000 => top bit = 1 (not XRP), sign=0, exponent=0, mantissa=0
            // Convert to an 8-byte array in big-endian order:
            return [0x80, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00];
        }

        $signBit = $isNegative ? 0 : 1;

        // -------------------------------------------------------------------------
        // 2) Normalize the number so the mantissa is in [10^15, 10^16-1]
        //    and compute the exponent in the process.
        // -------------------------------------------------------------------------
        // We'll separate the integer and fractional parts:
        $exponent = 0;

        // If there's a decimal point, remove it and adjust exponent
        $posDecimal = strpos($unsignedStr, '.');
        if ($posDecimal !== false) {
            // Number of fractional digits
            $fractionDigits = \strlen($unsignedStr) - ($posDecimal + 1);
            // Remove the decimal point
            $unsignedStr = str_replace('.', '', $unsignedStr);
            // Adjust exponent by negative the count of removed fraction digits
            // (e.g., "123.45" => "12345", exponent -= 2)
            $exponent -= $fractionDigits;
        }

        // Now $unsignedStr is an integer in decimal form (no sign, no decimal).
        // Remove leading zeros (but keep at least one digit if all zeros).
        $unsignedStr = ltrim($unsignedStr, '0');
        if ($unsignedStr === '') {
            // If we removed all digits (e.g. "0.000"), then it's zero,
            // but we already handled zero above. So let's just be safe:
            return [0x80, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00];
        }

        // We'll use BCMath to handle large numbers. Turn $unsignedStr into a BC number.
        // The exponent is the "unscaled" exponent so far. Next, we ensure mantissa
        // is within [10^15, 10^16-1].
        // Repeatedly scale up or down.

        // Define boundaries as strings:
        $lowerBound = '1000000000000000';  // 10^15
        $upperBound = '9999999999999999';  // 10^16 - 1

        // Scale up if less than 10^15
        while (bccomp($unsignedStr, $lowerBound) < 0) { // @phpstan-ignore-line
            // multiply the number by 10
            $unsignedStr = bcmul($unsignedStr, '10'); // @phpstan-ignore-line
            // exponent decreases by 1
            $exponent--;
        }

        // Scale down if >= 10^16
        $tenPower16 = '10000000000000000'; // 10^16
        while (bccomp($unsignedStr, $tenPower16) >= 0) { // @phpstan-ignore-line
            // divide by 10
            // note: bcdiv truncates, which is fine because we expect an integer
            $unsignedStr = bcdiv($unsignedStr, '10', 0);
            $exponent++;
        }

        // Now we have: 10^15 <= $unsignedStr <= 10^16 - 1, except exponent might be out of range
        // Also, check if exponent is within [-96, 80]
        if ($exponent < -96 || $exponent > 80) {
            throw new InvalidArgumentException("Exponent out of range: $exponent (valid range is -96 to +80).");
        }

        // -------------------------------------------------------------------------
        // 3) Compute serialized exponent = exponent + 97
        // -------------------------------------------------------------------------
        $serializedExponent = $exponent + 97; // => 1..177

        // -------------------------------------------------------------------------
        // 4) Build the 64-bit integer
        //
        // Bits layout (most significant to least significant):
        //   1 bit  - "not XRP" = 1
        //   1 bit  - sign (1=positive, 0=negative)
        //   8 bits - exponent (unsigned) = exponent + 97
        //   54 bits - mantissa
        //
        // => total 64 bits
        // -------------------------------------------------------------------------
        // We'll assemble it in a BCMath integer. We'll do bit-shifts carefully.
        // Then convert to an 8-byte (big-endian) array.
        //

        // not-xrp bit: 1 => (1 << 63)
        $notXrpMask = gmp_init('8000000000000000', 16); // 1 << 63

        // sign bit: if signBit=1 => set (1 << 62)
        if ($signBit === 1) {
            $signMask = gmp_init('4000000000000000', 16); // 1 << 62
        } else {
            $signMask = gmp_init('0', 10);
        }

        // exponent in bits 54..61 => shift exponent left 54 bits
        // (exponent is 8 bits => 0..255 in decimal)
        $exponentMask = gmp_init((string)($serializedExponent), 10);
        // shift left 54 bits:
        $pow2 = gmp_pow('2', 54);
        $exponentMask = gmp_mul($exponentMask, $pow2);

        // mantissa: 54 bits => 0..(2^54 - 1)
        // $unsignedStr can be up to 9999999999999999 => ~1e16 < 2^54
        $mantissaGmp = gmp_init($unsignedStr, 10);

        // Combine them:
        $combined = gmp_or($notXrpMask, $signMask);
        $combined = gmp_or($combined, $exponentMask);
        $combined = gmp_or($combined, $mantissaGmp);

        // -------------------------------------------------------------------------
        // 5) Convert the result to 8 bytes in big-endian order
        // -------------------------------------------------------------------------
        // Turn $combined into a 16-hex-digit string (64 bits => 8 bytes)
        $hex = gmp_strval($combined, 16);
        $hex = str_pad($hex, 16, '0', STR_PAD_LEFT);

        // Pack into a binary string, then unpack to array of bytes
        $binary = pack('H*', $hex);
        $bytes = unpack('C*', $binary);

        if ($bytes === false) {
            throw new InvalidArgumentException('Failed to unpack token amount.');
        }

        // Reindex from 0..7
        return array_values($bytes);
    }

    public static function fromJson(mixed $data): static
    {
        if (\is_string($data) === true) {
            return self::fromXRPAmount($data);
        }

        if (false === isset($data['currency']) || false === isset($data['issuer']) || false === isset($data['value'])) {
            throw new InvalidArgumentException('Invalid amount');
        }

        return self::fromIssuedAmount($data['value'], $data['currency'], $data['issuer']);
    }

    public static function fromXRPAmount(string $amount): static
    {
        return new static($amount);
    }

    public static function fromIssuedAmount(string $amount, string $currency, string $issuer): static
    {
        if ($currency === self::CURRENCY_XRP) {
            throw new InvalidArgumentException('Issued currency cannot be XRP.');
        }

        return new static($amount, $currency, $issuer);
    }
}
