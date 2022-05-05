<?php

namespace Awuxtron\Web3\Types;

use Awuxtron\Web3\Utils\Hex;
use Brick\Math\BigInteger;
use InvalidArgumentException;

class Block extends EthereumType
{
    public const LATEST = 'latest';
    public const EARLIEST = 'earliest';
    public const PENDING = 'pending';

    /**
     * Determine if the given value is block string.
     *
     * @param mixed $value
     *
     * @return bool
     */
    public static function isBlockString(mixed $value): bool
    {
        return in_array($value, [static::LATEST, static::EARLIEST, static::PENDING], true);
    }

    /**
     * Determine if the current type is dynamic.
     */
    public function isDynamic(): bool
    {
        return false;
    }

    /**
     * Validate the value is valid.
     *
     * @param mixed $value the value needs to be validated
     * @param bool  $throw throw an exception when validation returns false
     */
    public function validate(mixed $value, bool $throw = true): bool
    {
        if (!static::isBlockString($value)) {
            return (new Integer)->validate($value, $throw);
        }

        return !$throw ? false : throw new InvalidArgumentException('The given value is not a valid block.');
    }

    /**
     * Encodes value to its ABI representation.
     *
     * @param mixed $value
     * @param bool  $validate
     *
     * @return string
     */
    public function encode(mixed $value, bool $validate = true): string
    {
        if (static::isBlockString((string) $value)) {
            return $value;
        }

        return '0x' . ltrim((new Integer)->encode($value, $validate)->stripZeros(), '0');
    }

    /**
     * Decodes ABI encoded string to its Ethereum type.
     */
    public function decode(string|Hex $value): string|BigInteger
    {
        if (static::isBlockString((string) $value)) {
            return $value;
        }

        return (new Integer)->decode($value);
    }

    /**
     * Get the ethereum type name.
     */
    public function getName(): string
    {
        return 'block';
    }
}
