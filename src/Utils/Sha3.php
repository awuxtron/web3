<?php

namespace Awuxtron\Web3\Utils;

use Exception;
use kornrunner\Keccak;

class Sha3
{
    public const SHA3_NULL_HASH = 'c5d2460186f7233c927e7db2dcc703c0e500b653ca82273b7bfad8045d85a470';

    /**
     * Hashes values to a sha3 hash using keccak 256.
     */
    public static function hash(string $str, bool $raw = false): ?Hex
    {
        if (Hex::isValid($str, true)) {
            $str = pack('H*', Hex::of($str));
        }

        try {
            $hash = Keccak::hash($str, 256);
        } catch (Exception) {
            $hash = self::SHA3_NULL_HASH;
        }

        if (!$raw && $hash === self::SHA3_NULL_HASH) {
            return null;
        }

        return Hex::of($hash);
    }
}
