<?php

namespace Awuxtron\Web3\Utils;

use JsonException;

class Json
{
    /**
     * Wrapper for json_decode function.
     *
     * @param string $json
     * @param bool   $isFile
     *
     * @throws JsonException
     *
     * @return array<mixed>
     */
    public static function decode(string $json, bool $isFile = false): array
    {
        if ($isFile) {
            $json = (string) file_get_contents($json);
        }

        return json_decode($json, true, 512, JSON_BIGINT_AS_STRING | JSON_THROW_ON_ERROR);
    }

    /**
     * Wrapper for json_encode function.
     *
     * @param array<mixed> $value
     * @param int          $flags
     *
     * @throws JsonException
     *
     * @return string
     */
    public static function encode(array $value, int $flags = 0): string
    {
        return json_encode($value, $flags | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
    }
}
