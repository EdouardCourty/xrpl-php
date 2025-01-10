<?php
declare(strict_types=1);

namespace XRPL\Service\Denormalizer;

use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use XRPL\Model\Account\Nested\NFTObject;

/**
 * @author Edouard Courty <edouard.courty2@gmail.com>
 */
class NFTokenObjectDenormalizer implements DenormalizerInterface
{
    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): NFTObject
    {
        $NFTObject = new NFTObject();
        $NFTObject->NFTokenId = $data['NFTokenID'];
        $NFTObject->uri = $data['URI'];
        $NFTObject->flags = $data['Flags'];
        $NFTObject->issuer = $data['Issuer'];
        $NFTObject->NFTokenTaxon = $data['NFTokenTaxon'];
        $NFTObject->nftSerial = $data['nft_serial']; // This is a mistake in the API response. https://xrpl.org/docs/references/http-websocket-apis/public-api-methods/account-methods/account_nfts

        return $NFTObject;
    }

    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        return $type === NFTObject::class;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            NFTObject::class => true,
        ];
    }
}
