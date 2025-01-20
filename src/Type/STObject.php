<?php

declare(strict_types=1);

namespace XRPL\Type;

use XRPL\Service\TransactionEncoder;

class STObject extends AbstractBinaryType
{
    public const string ST_OBJECT_END_MARKER = 'ObjectEndMarker';

    public const int ST_OBJECT_END_MARKER_VALUE = 0xe1;

    public static function fromJson(mixed $data): static
    {
        if (\is_array($data) === false) {
            throw new \InvalidArgumentException('STObject data must be an array');
        }

        $serializedFields = TransactionEncoder::serializeFields($data);
        $sorted = TransactionEncoder::sortFields($serializedFields);

        $stObjectArray = [];

        foreach ($sorted as $value) {
            $stObjectArray = array_merge($stObjectArray, $value);
        }

        return new static($stObjectArray);
    }

    public static function isSTObject(array $data): bool
    {
        $memberKeys = array_keys($data);
        if (\count($memberKeys) !== 1) {
            return false;
        }

        if (\is_array($data[$memberKeys[0]]) === false) {
            return false;
        }

        return true;
    }
}
