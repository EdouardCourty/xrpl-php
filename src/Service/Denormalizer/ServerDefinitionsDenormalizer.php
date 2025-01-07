<?php

declare(strict_types=1);

namespace XRPL\Service\Denormalizer;

use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use XRPL\Model\ServerInfo\ServerDefinitions;

class ServerDefinitionsDenormalizer implements DenormalizerInterface
{
    public function supportsDenormalization(
        mixed $data,
        string $type,
        ?string $format = null,
        array $context = [],
    ): bool {
        return $type === ServerDefinitions::class;
    }

    public function denormalize(
        mixed $data,
        string $type,
        ?string $format = null,
        array $context = [],
    ): ServerDefinitions {
        $serverDefinitions = new ServerDefinitions();
        $serverDefinitions->hash = $data['hash'];
        $serverDefinitions->fields = $data['FIELDS'];
        $serverDefinitions->ledgerEntryTypes = $data['LEDGER_ENTRY_TYPES'];
        $serverDefinitions->transactionResults = $data['TRANSACTION_RESULTS'];
        $serverDefinitions->transactionTypes = $data['TRANSACTION_TYPES'];
        $serverDefinitions->status = $data['status'];

        return $serverDefinitions;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            ServerDefinitions::class => true,
        ];
    }
}
