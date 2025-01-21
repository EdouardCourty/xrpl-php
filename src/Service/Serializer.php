<?php

declare(strict_types=1);

namespace XRPL\Service;

use Symfony\Component\PropertyAccess\PropertyAccessor;
use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;
use Symfony\Component\Serializer\Encoder\JsonDecode;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AttributeLoader;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use XRPL\Service\Denormalizer\CurrencyAmountDenormalizer;
use XRPL\Service\Denormalizer\LedgerEntry\NFTokenOfferDenormalizer;
use XRPL\Service\Denormalizer\LedgerEntryDenormalizer;
use XRPL\Service\Denormalizer\NFTokenDenormalizer;
use XRPL\Service\Denormalizer\NFTokenObjectDenormalizer;
use XRPL\Service\Denormalizer\NFTokenPageDenormalizer;
use XRPL\Service\Denormalizer\TransactionDenormalizer;

/**
 * @author Edouard Courty
 */
class Serializer extends \Symfony\Component\Serializer\Serializer
{
    public function __construct()
    {
        $phpDocExtractor = new PhpDocExtractor();
        $reflectionExtractor = new ReflectionExtractor();

        $propertyInfoExtractor = new PropertyInfoExtractor(
            [$phpDocExtractor, $reflectionExtractor], // @phpstan-ignore-line
            [$phpDocExtractor, $reflectionExtractor],
            [$phpDocExtractor, $reflectionExtractor], // @phpstan-ignore-line
            [$reflectionExtractor],
            [$reflectionExtractor],
        );

        $normalizers = [
            new CurrencyAmountDenormalizer(),
            new LedgerEntryDenormalizer($this),
            new NFTokenPageDenormalizer($this),
            new TransactionDenormalizer($this),
            new NFTokenObjectDenormalizer(),
            new NFTokenDenormalizer(),
            new NFTokenOfferDenormalizer($this),
            new ArrayDenormalizer(),
            new DateTimeNormalizer(),
            new ObjectNormalizer(
                new ClassMetadataFactory(new AttributeLoader()),
                new CamelCaseToSnakeCaseNameConverter(),
                new PropertyAccessor(),
                $propertyInfoExtractor,
                null,
                null,
                [],
                $propertyInfoExtractor,
            ),
        ];

        $decoders = [
            new JsonDecode([JsonDecode::ASSOCIATIVE => true]),
        ];

        parent::__construct($normalizers, $decoders);
    }
}
