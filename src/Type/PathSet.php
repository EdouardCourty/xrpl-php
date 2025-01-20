<?php

declare(strict_types=1);

namespace XRPL\Type;

class PathSet extends AbstractBinaryType
{
    private const int FLAG_ACCOUNT = 0x01;
    private const int FLAG_CURRENCY = 0x10;
    private const int FLAG_ISSUER = 0x20;

    private const int ANOTHER_PATH_FOLLOWS = 0xff;
    private const int PATH_END = 0x00;

    private const array FIELDS_SORT_ORDER = [
        'account',
        'currency',
        'issuer',
    ];

    /**
     * @var array<string, class-string<AbstractBinaryType>>
     */
    private const array FIELDS_MAPPING = [
        'account' => AccountID::class,
        'currency' => Currency::class,
        'issuer' => AccountID::class,
    ];

    public static function fromJson(mixed $data): static
    {
        if (\is_array($data) === false) {
            throw new \InvalidArgumentException('PathSet data is not an array');
        }

        if (empty($data) === true || \count($data) > 6) {
            throw new \InvalidArgumentException('PathSet data is empty or has more than 6 elements');
        }

        $byteArray = [];

        foreach ($data as $path) {
            $subByteArray = [];

            foreach ($path as $pathData) {
                if (empty($pathData) === true || \count($pathData) > 8) {
                    throw new \InvalidArgumentException('PathSet path data has more than 8 elements');
                }

                $sortedFields = self::sortFields($pathData);

                $prefix = self::getFieldPrefix($pathData);

                $content = self::serializeFields($sortedFields);
                $pathContent = array_merge([$prefix], $content); // Build the path content

                $subByteArray = array_merge($subByteArray, $pathContent);
            }

            $isLastElement = next($data) === false;
            $suffix = $isLastElement ? self::PATH_END : self::ANOTHER_PATH_FOLLOWS;

            $subByteWithSuffix = array_merge($subByteArray, [$suffix]);
            $byteArray = array_merge($byteArray, $subByteWithSuffix);
        }

        return new static($byteArray);
    }

    private static function serializeFields(array $fields): array
    {
        $serialized = [];

        foreach ($fields as $key => $value) {
            $fieldDefinition = self::FIELDS_MAPPING[$key]::fromJson($value);

            $bytes = $fieldDefinition->getBytes();
            if ($key === 'currency' && $value === 'XRP') {
                $bytes = array_fill(0, 20, 0x00); // 160 bits of zeroes = 20 zeroes (160 / 8)
            }

            $serialized = array_merge($serialized, $bytes);
        }

        return $serialized;
    }

    private static function getFieldPrefix(array $fields): int
    {
        $prefix = 0x00;

        if (isset($fields['account']) === true) {
            $prefix |= self::FLAG_ACCOUNT;
        }

        if (isset($fields['currency']) === true) {
            $prefix |= self::FLAG_CURRENCY;
        }

        if (isset($fields['issuer']) === true) {
            $prefix |= self::FLAG_ISSUER;
        }

        return $prefix;
    }

    /**
     * Sorts the Path fields in the order they should be serialized.
     */
    private static function sortFields(array $fields): array
    {
        uksort($fields, function ($a, $b) {
            return array_search($a, self::FIELDS_SORT_ORDER) - array_search($b, self::FIELDS_SORT_ORDER);
        });

        return $fields;
    }
}
