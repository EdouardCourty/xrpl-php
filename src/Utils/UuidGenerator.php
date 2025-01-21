<?php

declare(strict_types=1);

namespace XRPL\Utils;

/**
 * @author Edouard Courty
 */
class UuidGenerator
{
    final public static function v4(): string
    {
        $data = random_bytes(16);
        $data[6] = \chr(\ord($data[6]) & 0x0f | 0x40);
        $data[8] = \chr(\ord($data[8]) & 0x3f | 0x80);

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', mb_str_split(bin2hex($data), 4));
    }
}
