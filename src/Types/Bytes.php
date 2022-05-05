<?php

namespace Awuxtron\Web3\Types;

use Awuxtron\Web3\Utils\Hex;
use Brick\Math\BigInteger;
use Brick\Math\BigNumber;
use InvalidArgumentException;

class Bytes extends EthereumType
{
    /**
     * Create a new bytes type object.
     *
     * @param null|int $bytes
     */
    public function __construct(protected ?int $bytes = null)
    {
        if ($bytes !== null && ($bytes <= 0 || $bytes > 32)) {
            throw new InvalidArgumentException('Invalid bytes.');
        }
    }

    /**
     * Determine if the current type is dynamic.
     */
    public function isDynamic(): bool
    {
        return $this->bytes === null;
    }

    /**
     * Validate the value is valid.
     *
     * @param mixed $value the value needs to be validated
     * @param bool  $throw throw an exception when validation returns false
     */
    public function validate(mixed $value, bool $throw = true): bool
    {
        if (!Hex::isValid($value)) {
            return !$throw ? false : throw new InvalidArgumentException('Invalid hex string.');
        }

        if (!empty($this->bytes) && Hex::of($value)->length() != $this->bytes) {
            return !$throw ? false : throw new InvalidArgumentException('Invalid bytes size.');
        }

        return true;
    }

    /**
     * Validate the value and return the valid hex object.
     *
     * @param mixed $value
     *
     * @return Hex
     */
    public function validated(mixed $value): Hex
    {
        return Hex::of(parent::validated($value));
    }

    /**
     * Encodes value to its ABI representation.
     */
    public function encode(mixed $value, bool $validate = true): Hex
    {
        if ($validate) {
            $this->validate($value);
        }

        $pad = static fn (Hex $hex) => $hex->padRight(32);

        return Hex::of(implode('', array_map($pad, Hex::of($value)->split(32))));
    }

    /**
     * Decodes ABI encoded string to its Ethereum type.
     */
    public function decode(string|Hex $value): Hex
    {
        return Hex::of($value);
    }

    /**
     * Get the ethereum type name.
     */
    public function getName(): string
    {
        return "bytes{$this->bytes}";
    }

    /**
     * Get size of the value for dynamic-type.
     */
    public function getValueSize(mixed $value): ?int
    {
        return $this->bytes == null ? Hex::of($value)->length() : null;
    }

    /**
     * Get the bytes size of encoded hex string.
     *
     * @param null|BigNumber|int $length
     *
     * @return BigInteger
     */
    public function getBytesSize(int|BigNumber|null $length = null): BigInteger
    {
        if ($this->bytes != null) {
            return BigInteger::of(32);
        }

        if ($length == null) {
            throw new InvalidArgumentException('Length must be specified when this type is dynamic.');
        }

        return nearest_divisible(BigInteger::of($length), 32);
    }
}
