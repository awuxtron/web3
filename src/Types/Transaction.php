<?php

namespace Awuxtron\Web3\Types;

use Awuxtron\Web3\Utils\Hex;
use InvalidArgumentException;

class Transaction extends EthereumType
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
        if (!is_array($value)) {
            return !$throw ? false : throw new InvalidArgumentException('The given value must be of type array.');
        }

        if (!array_key_exists('to', $value)) {
            return !$throw ? false : throw new InvalidArgumentException('Missing required param: to.');
        }

        if (!(new Address)->validate($value['to'], false)) {
            return !$throw ? false : throw new InvalidArgumentException('The parameter "to" must be a valid ethereum address.');
        }

        if (array_key_exists('from', $value) && !(new Address)->validate($value['from'], false)) {
            return !$throw ? false : throw new InvalidArgumentException('The parameter "from" must be a valid ethereum address.');
        }

        if (array_key_exists('gas', $value) && !(new Integer)->validate($value['gas'], false)) {
            return !$throw ? false : throw new InvalidArgumentException('The parameter "gas" must be a valid number.');
        }

        if (array_key_exists('gasPrice', $value) && !(new Integer)->validate($value['gasPrice'], false)) {
            return !$throw ? false : throw new InvalidArgumentException('The parameter "gasPrice" must be a valid number.');
        }

        if (array_key_exists('value', $value) && !(new Integer)->validate($value['value'], false)) {
            return !$throw ? false : throw new InvalidArgumentException('The parameter "value" must be a valid number.');
        }

        if (array_key_exists('data', $value) && !Hex::isValid($value['data'], false, true)) {
            return !$throw ? false : throw new InvalidArgumentException('The parameter "data" must be a valid hex string.');
        }

        return true;
    }

    /**
     * Encodes value to its ABI representation.
     *
     * @param mixed $value
     * @param bool  $validate
     *
     * @return array<string, string>
     */
    public function encode(mixed $value, bool $validate = true): array
    {
        if ($validate) {
            $this->validate($value);
        }

        $value['to'] = Hex::of($value['to'])->stripZeros()->prefixed();

        if (array_key_exists('from', $value)) {
            $value['from'] = Hex::of($value['from'])->stripZeros()->prefixed();
        }

        if (array_key_exists('gas', $value)) {
            $value['gas'] = Hex::fromInteger($value['gas'])->prefixed();
        }

        if (array_key_exists('gasPrice', $value)) {
            $value['gasPrice'] = Hex::fromInteger($value['gasPrice'])->prefixed();
        }

        if (array_key_exists('value', $value)) {
            $value['value'] = Hex::fromInteger($value['value'])->prefixed();
        }

        if (array_key_exists('data', $value)) {
            $value['data'] = Hex::of($value['data'])->prefixed();
        }

        return $value;
    }

    /**
     * Decodes ABI encoded string to its Ethereum type.
     */
    public function decode(string|Hex $value): mixed
    {
        return null;
    }

    /**
     * Get the ethereum type name.
     */
    public function getName(): string
    {
        return 'transaction';
    }
}
