<?php

namespace Awuxtron\Web3\Types;

use Awuxtron\Web3\Utils\Hex;
use InvalidArgumentException;

class Boolean extends EthereumType
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
        if (!in_array((string) $value, ['true', 'false', '0', '1'], true) && !is_bool($value)) {
            return !$throw ? false : throw new InvalidArgumentException('The value must be of type boolean.');
        }

        return true;
    }

    /**
     * Encodes value to its ABI representation.
     */
    public function encode(mixed $value, bool $validate = true, bool $pad = true): Hex
    {
        if ($validate) {
            $this->validate($value);
        }

        if (is_string($value)) {
            $value = match ($value) {
                'true', '1' => true,
                'false', '0' => false,
                default => null
            };
        }

        $hex = Hex::fromBoolean($value);

        if (!$pad) {
            return $hex;
        }

        return $hex->padLeft(32);
    }

    /**
     * Decodes ABI encoded string to its Ethereum type.
     */
    public function decode(mixed $value): bool
    {
        if (is_bool($value)) {
            return $value;
        }

        return Hex::of($value)->toBoolean();
    }

    /**
     * Get the ethereum type name.
     */
    public function getName(): string
    {
        return 'bool';
    }
}
