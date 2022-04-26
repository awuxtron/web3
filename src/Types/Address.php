<?php

namespace Awuxtron\Web3\Types;

use Awuxtron\Web3\Utils\Address as AddressUtil;
use Awuxtron\Web3\Utils\Hex;
use InvalidArgumentException;

class Address extends EthereumType
{
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
        if (!AddressUtil::isValid($value)) {
            return !$throw ? false : throw new InvalidArgumentException('The given value is not a valid ethereum address.');
        }

        return true;
    }

    /**
     * Encodes value to its ABI representation.
     */
    public function encode(mixed $value, bool $validate = true): Hex
    {
        if ($validate) {
            $this->validate($value);
        }

        return Hex::of($value)->padLeft(32)->lower();
    }

    /**
     * Decodes ABI encoded string to its Ethereum type.
     */
    public function decode(string|Hex $value): Hex
    {
        return Hex::of($value)->stripZeros();
    }

    /**
     * Get the ethereum type name.
     */
    public function getName(): string
    {
        return 'address';
    }
}
