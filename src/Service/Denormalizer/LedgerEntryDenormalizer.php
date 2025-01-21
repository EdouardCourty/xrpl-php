<?php

declare(strict_types=1);

namespace XRPL\Service\Denormalizer;

use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use XRPL\Enum\LedgerEntryTypeEnum;
use XRPL\Model\Ledger\LedgerEntry\AbstractLedgerEntry;
use XRPL\Service\Serializer;

/**
 * @author Edouard Courty
 */
readonly class LedgerEntryDenormalizer implements DenormalizerInterface
{
    public function __construct(
        private Serializer $serializer,
    ) {
    }

    public function supportsDenormalization(
        mixed $data,
        string $type,
        ?string $format = null,
        array $context = [],
    ): bool {
        return $type === AbstractLedgerEntry::class;
    }

    public function denormalize(
        mixed $data,
        string $type,
        ?string $format = null,
        array $context = [],
    ): AbstractLedgerEntry {
        $type = $data['LedgerEntryType'];
        $ledgerEntryType = LedgerEntryTypeEnum::tryFrom($type) ?: LedgerEntryTypeEnum::Unknown;

        return $this->serializer->deserialize(json_encode($data), $ledgerEntryType->getClass(), 'json');
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            AbstractLedgerEntry::class => true,
        ];
    }
}
