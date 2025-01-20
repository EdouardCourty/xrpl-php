<?php

declare(strict_types=1);

namespace XRPL\Type;

use XRPL\Service\Signature\ServerDefinitions;

class STArray extends AbstractBinaryType
{
    public const int ST_OBJECT_END_MARKER_VALUE = 0xf1;

    public static function fromJson(mixed $data): static
    {
        if (\is_array($data) === false) {
            throw new \InvalidArgumentException('STArray data must be an array');
        }

        $bytes = [];

        foreach ($data as $item) {
            if (STObject::isSTObject($item) === false) {
                throw new \UnexpectedValueException('STArray members must contain only one key, which itself contains an array.');
            }

            $fieldBytes = STObject::fromJson($item);

            $bytes = array_merge($bytes, $fieldBytes->getBytes());
        }

        return new static(array_merge($bytes, [self::ST_OBJECT_END_MARKER_VALUE]));
    }
}
