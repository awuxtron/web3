<?php

namespace Awuxtron\Web3\Types;

use Awuxtron\Web3\Utils\Hex;
use InvalidArgumentException;

class Topics extends EthereumType
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
            return $this->throw(throw new InvalidArgumentException('The value must be type of array.'), $throw);
        }

        if (empty($value)) {
            return true;
        }

        if (!array_is_list($value)) {
            return $this->throw(new InvalidArgumentException('The value must be a list.'), $throw);
        }

        $filtered = array_filter($value, function ($item) use ($throw) {
            if (is_array($item)) {
                return $this->validate($item, $throw);
            }

            return $item === null || (new Bytes(32))->validate($item, $throw);
        });

        return count($filtered) == count($value);
    }

    /**
     * Encodes value to its ABI representation.
     *
     * @param mixed $value
     * @param bool  $validate
     * @param bool  $pad
     *
     * @return array<mixed>
     */
    public function encode(mixed $value, bool $validate = true, bool $pad = true): array
    {
        if ($validate) {
            $this->validate($value);
        }

        $encoder = function ($v) use ($pad) {
            if ($v === null) {
                return null;
            }

            if (is_array($v)) {
                return $this->encode($v, false, $pad);
            }

            return Hex::of($v)->prefixed();
        };

        return array_map($encoder, $value);
    }

    /**
     * Decodes ABI encoded string to its Ethereum type.
     *
     * @param mixed $value
     *
     * @return array<mixed>
     */
    public function decode(mixed $value): array
    {
        $decoder = function ($v) {
            if ($v === null) {
                return null;
            }

            if (is_array($v)) {
                return $this->decode($v);
            }

            return Hex::of($v);
        };

        return array_map($decoder, $this->validated($value));
    }

    /**
     * Get the ethereum type name.
     */
    public function getName(): string
    {
        return 'topics';
    }
}
