<?php

declare(strict_types=1);

namespace XRPL\Model\Account\Nested;

use Symfony\Component\Serializer\Attribute\SerializedName;

class NFTObject
{
    public int $flags;
    public string $issuer;
    #[SerializedName('NFTokenID')]
    public string $NFTokenId;
    #[SerializedName('NFTokenTaxon')]
    public int $NFTokenTaxon;
    #[SerializedName('URI')]
    public string $uri;
    public int $nftSerial;
}
