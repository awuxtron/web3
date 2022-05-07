<?php

namespace Awuxtron\Web3\Types;

use Awuxtron\Web3\Exceptions\HexException;
use Awuxtron\Web3\Utils\Hex;
use InvalidArgumentException;

class Str extends EthereumType
{
    /**
     * Determine if the current type is dynamic.
     */
    public function isDynamic(): bool
    {
        return true;
    }

    /**
     * Validate the value is valid.
     *
     * @param mixed $value the value needs to be validated
     * @param bool  $throw throw an exception when validation returns false
     */
    public function validate(mixed $value, bool $throw = true): bool
    {
        if (!is_string($value)) {
            return !$throw ? false : throw new InvalidArgumentException('The given value must be a valid string.');
        }

        return true;
    }

    /**
     * Encodes value to its ABI representation.
     *
     * @throws HexException
     */
    public function encode(mixed $value, bool $validate = true, bool $pad = true): Hex
    {
        if ($validate) {
            $this->validate($value);
        }

        return (new Bytes)->encode(Hex::fromString($value), false, $pad);
    }

    /**
     * Decodes ABI encoded string to its Ethereum type.
     *
     * @throws HexException
     */
    public function decode(mixed $value): string
    {
        return Hex::of($value)->toString();
    }

    /**
     * Get the ethereum type name.
     */
    public function getName(): string
    {
        return 'string';
    }

    /**
     * Get size of the value for dynamic-type.
     */
    public function getValueSize(mixed $value): ?int
    {
        return strlen($value);
    }
}
