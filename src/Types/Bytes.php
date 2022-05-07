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
    }

    /**
     * Determine if the current type is dynamic.
     */
    public function isDynamic(): bool
    {
        return $this->bytes === null || $this->bytes > 32;
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
    public function encode(mixed $value, bool $validate = true, bool $pad = true): Hex
    {
        if ($validate) {
            $this->validate($value);
        }

        $p = static fn (Hex $hex) => $pad ? $hex->padRight(32) : $hex;

        return Hex::of(implode('', array_map($p, Hex::of($value)->split(32))));
    }

    /**
     * Decodes ABI encoded string to its Ethereum type.
     */
    public function decode(mixed $value): Hex
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
        return $this->bytes == null || $this->bytes > 32 ? Hex::of($value)->length() : null;
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
        if ($this->bytes != null && $this->bytes <= 32) {
            return BigInteger::of(32);
        }

        if ($length == null) {
            throw new InvalidArgumentException('Length must be specified when this type is dynamic.');
        }

        return nearest_divisible(BigInteger::of($length), 32);
    }
}
