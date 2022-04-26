<?php

use Awuxtron\Web3\Utils\Hex;
use Awuxtron\Web3\Utils\Sha3;
use Brick\Math\BigInteger;

if (!function_exists('sha3')) {
    /**
     * Hashes values to a sha3 hash using keccak 256.
     */
    function sha3(string $str, bool $raw = false): ?Hex
    {
        return Sha3::hash($str, $raw);
    }
}

if (!function_exists('nearest_divisible')) {
    /**
     * Find the nearest number larger than $a divisible by $b.
     *
     * @param BigInteger|int $a
     * @param BigInteger|int $b
     *
     * @return BigInteger
     */
    function nearest_divisible(BigInteger|int $a, BigInteger|int $b): BigInteger
    {
        $a = BigInteger::of($a)->minus(1);
        $b = BigInteger::of($b);

        return $a->plus($b)->minus($a->remainder($b));
    }
}

if (!function_exists('explode_top_level')) {
    /**
     * Explode string by separator outside parentheses.
     *
     * @phpstan-param non-empty-string $tmp
     *
     * @param string $separator
     * @param string $string
     * @param int    $limit
     * @param string $tmp
     *
     * @return string[]
     */
    function explode_top_level(string $separator, string $string, int $limit = PHP_INT_MAX, string $tmp = '&'): array
    {
        $replacer = static fn ($matches) => $matches[0] === $separator ? $tmp : $matches[0];

        return explode($tmp, (string) preg_replace_callback("/({$separator})|\\((((?>[^()]+)|(?R))*)\\)/", $replacer, $string), $limit);
    }
}
