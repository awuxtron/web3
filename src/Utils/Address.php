<?php

namespace Awuxtron\Web3\Utils;

use InvalidArgumentException;

class Address
{
    /**
     * Checks if the given string is valid Ethereum address.
     */
    public static function isValid(Hex|string $address): bool
    {
        $address = Hex::of($address);

        if (!self::isValidHex($address)) {
            return false;
        }

        return self::isAllSameCaps($address) || self::isValidChecksum($address->prefixed());
    }

    /**
     * Checks if given address have a valid checksum.
     */
    public static function isValidChecksum(string $address): bool
    {
        if (!self::isValidHex($address)) {
            throw new InvalidArgumentException("Given address '{$address}' is not a valid Ethereum address.");
        }

        $address = (string) Hex::of($address);
        $hash = (string) Sha3::hash(strtolower($address));

        for ($i = 0; $i < 40; ++$i) {
            if (ctype_alpha($address[$i])) {
                $charInt = intval($hash[$i], 16);

                if ((ctype_upper($address[$i]) && $charInt <= 7) || (ctype_lower($address[$i]) && $charInt > 7)) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Convert the given address to a valid checksum address.
     */
    public static function toChecksum(string $address): Hex
    {
        if (!self::isValidHex($address)) {
            throw new InvalidArgumentException("Given address '{$address}' is not a valid Ethereum address.");
        }

        $result = '';
        $address = strtolower(Hex::of($address));
        $hash = (string) Sha3::hash($address);

        for ($i = 0, $iMax = strlen($address); $i < $iMax; ++$i) {
            if (intval($hash[$i], 16) > 7) {
                $result .= strtoupper($address[$i]);
            } else {
                $result .= $address[$i];
            }
        }

        return Hex::of($result);
    }

    /**
     * Checks if given address is a valid hex string.
     */
    protected static function isValidHex(Hex|string $address): bool
    {
        return Hex::of($address)->length() === 20;
    }

    /**
     * Checks if all characters in the given string have same caps.
     */
    protected static function isAllSameCaps(string $str): bool
    {
        return strtolower($str) === $str || strtoupper($str) === $str;
    }
}
