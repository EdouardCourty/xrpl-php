<?php

namespace XRPL\Denormalizer;

use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use XRPL\Model\Ledger\LedgerEntryNode;

class LedgerEntryNodeDenormalizer implements DenormalizerInterface
{
    public function supportsDenormalization(
        mixed $data,
        string $type,
        ?string $format = null,
        array $context = []
    ): bool {
        return $type === LedgerEntryNode::class;
    }

    public function denormalize(
        mixed $data,
        string $type,
        ?string $format = null,
        array $context = []
    ): LedgerEntryNode {
        $ledgerEntryNode = new LedgerEntryNode();
        $ledgerEntryNode->data = json_decode(json_encode($data), true);
        // TODO: Implement proper denormalization by type

        return $ledgerEntryNode;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            LedgerEntryNode::class => true,
        ];
    }
}
