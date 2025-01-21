<?php

declare(strict_types=1);

namespace XRPL\Service\Denormalizer\LedgerEntry;

use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use XRPL\Model\Common\CurrencyAmount;
use XRPL\Model\Ledger\LedgerEntry\NFTokenOffer;
use XRPL\Service\Serializer;

/**
 * @author Edouard Courty
 */
readonly class NFTokenOfferDenormalizer implements DenormalizerInterface
{
    public function __construct(
        private Serializer $serializer,
    ) {
    }

    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): mixed
    {
        $NFTokenOffer = new NFTokenOffer();

        $NFTokenOffer->index = isset($data['index']) ? (string) $data['index'] : null;
        $NFTokenOffer->ledgerEntryType = (string) $data['LedgerEntryType'];
        $NFTokenOffer->flags = (int) $data['Flags'];
        $NFTokenOffer->amount = $this->serializer->deserialize(json_encode($data['Amount']), CurrencyAmount::class, 'json');
        $NFTokenOffer->destination = isset($data['Destination']) ? (string) $data['Destination'] : null;
        $NFTokenOffer->expiration = isset($data['Expiration']) ? (int) $data['Expiration'] : null;
        $NFTokenOffer->NFTokenId = (string) $data['NFTokenID'];
        $NFTokenOffer->NFTokenOfferNode = isset($data['NFTokenOfferNode']) ? (string) $data['NFTokenOfferNode'] : null;
        $NFTokenOffer->owner = (string) $data['Owner'];
        $NFTokenOffer->ownerNode = isset($data['OwnerNode']) ? (string) $data['OwnerNode'] : null;
        $NFTokenOffer->previousTxnID = (string) $data['PreviousTxnID'];
        $NFTokenOffer->previousTxnLgrSeq = (int) $data['PreviousTxnLgrSeq'];

        return $NFTokenOffer;
    }

    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        return $type === NFTokenOffer::class;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            NFTokenOffer::class => true,
        ];
    }
}
