<?php

declare(strict_types=1);

namespace XRPL\Service\Denormalizer;

use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use XRPL\Enum\TransactionTypeEnum;
use XRPL\Model\AbstractTransaction;
use XRPL\Service\Serializer;

readonly class TransactionDenormalizer implements DenormalizerInterface
{
    public function __construct(private Serializer $serializer)
    {
    }

    public function denormalize(
        mixed $data,
        string $type,
        ?string $format = null,
        array $context = [],
    ): ?AbstractTransaction {
        if (false === is_array($data)) {
            return null;
        }

        $transactionType = TransactionTypeEnum::tryFrom($data['TransactionType']) ?: TransactionTypeEnum::Unknown;

        return $this->serializer->deserialize(json_encode($data), $transactionType->getClass(), 'json');
    }

    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        return $type === AbstractTransaction::class;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            AbstractTransaction::class => true,
        ];
    }
}
