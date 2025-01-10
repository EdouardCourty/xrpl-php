<?php
declare(strict_types=1);

namespace XRPL\Service\Denormalizer;

use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use XRPL\Model\Ledger\LedgerEntry\Nested\NFToken;
use XRPL\Model\Ledger\LedgerEntry\NFTokenPage;
use XRPL\Service\Serializer;

/**
 * @author Edouard Courty <edouard.courty2@gmail.com>
 */
readonly class NFTokenPageDenormalizer implements DenormalizerInterface
{
    public function __construct(
        private Serializer $serializer,
    ) {
    }

    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): mixed
    {
        $NFTokenPage = new NFTokenPage();

        $NFTokenPage->index = $data['index'] ?? null;
        $NFTokenPage->ledgerEntryType = $data['LedgerEntryType'];
        $NFTokenPage->flags = $data['Flags'];
        $NFTokenPage->nextPageMin = $data['NextPageMin'] ?? null;
        $NFTokenPage->NFTokens = array_map(
            fn(array $NFToken) => $this->serializer->deserialize(json_encode($NFToken), NFToken::class, 'json'),
            $data['NFTokens'],
        );
        $NFTokenPage->previousPageMin = $data['PreviousPageMin'] ?? null;
        $NFTokenPage->previousTxnID = $data['PreviousTxnID'] ?? null;
        $NFTokenPage->previousTxnLgrSeq = $data['PreviousTxnLgrSeq'] ?? null;

        return $NFTokenPage;
    }

    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        return $type === NFTokenPage::class;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            NFTokenPage::class => true,
        ];
    }
}
