<?php

declare(strict_types=1);

namespace XRPL\Service\Denormalizer;

use Symfony\Component\Serializer\Exception\UnexpectedValueException;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use XRPL\Model\Common\CurrencyAmount;

/**
 * @author Edouard Courty <edouard.courty2@gmail.com>
 */
class CurrencyAmountDenormalizer implements DenormalizerInterface
{
    public function supportsDenormalization(
        mixed $data,
        string $type,
        ?string $format = null,
        array $context = [],
    ): bool {
        return $type === CurrencyAmount::class;
    }

    public function denormalize(
        mixed $data,
        string $type,
        ?string $format = null,
        array $context = [],
    ): CurrencyAmount {
        if (\is_string($data)) {
            return CurrencyAmount::fromXRP($data);
        }

        if (isset($data['currency'], $data['issuer'], $data['value'])) {
            return CurrencyAmount::fromIssued($data['currency'], $data['value'], $data['issuer']);
        }

        throw new UnexpectedValueException(\sprintf('Invalid data for CurrencyAmount: %s', json_encode($data)));
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            CurrencyAmount::class => true,
        ];
    }
}
