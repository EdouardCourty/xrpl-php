<?php

declare(strict_types=1);

namespace XRPL\Service\Denormalizer;

use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use XRPL\Model\Ledger\LedgerEntry\Nested\NFToken;

class NFTokenDenormalizer implements DenormalizerInterface
{
    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): mixed
    {
        $NFToken = new NFToken();

        $NFToken->NFTokenID = $data['NFToken']['NFTokenID'];
        $NFToken->uri = $data['NFToken']['URI'];

        return $NFToken;
    }

    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        return $type === NFToken::class;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            NFToken::class => true,
        ];
    }
}
