<?php

namespace Awuxtron\Web3\Types;

use InvalidArgumentException;

class Plain extends EthereumType
{
    /**
     * Create a new plain type instance.
     *
     * @param string $type
     */
    public function __construct(protected string $type)
    {
        $this->type = match ($type) {
            'arr' => 'array',
            'bool' => 'boolean',
            'int' => 'integer',
            'float', 'fixed' => 'double',
            'str' => 'string',
            'obj' => 'object',
            default => $type,
        };
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
        $type = gettype($value);

        if ($type == 'integer' && $this->type == 'double') {
            return true;
        }

        if ($type != $this->type) {
            return $this->throw(new InvalidArgumentException("The given value must be of type {$this->type}."), $throw);
        }

        return true;
    }

    /**
     * Encodes value to its ABI representation.
     */
    public function encode(mixed $value, bool $validate = true, bool $pad = true): mixed
    {
        if ($validate) {
            $this->validate($value);
        }

        settype($value, $this->type);

        return $value;
    }

    /**
     * Decodes ABI encoded string to its Ethereum type.
     */
    public function decode(mixed $value): mixed
    {
        $value = $this->validated($value);

        settype($value, $this->type);

        return $value;
    }

    /**
     * Get the ethereum type name.
     */
    public function getName(): string
    {
        return "plain:{$this->type}";
    }

    /**
     * Get the valid PHP type.
     *
     * @return string
     */
    public function getPhpType(): string
    {
        return match ($this->type) {
            'array' => 'array',
            'boolean' => 'bool',
            'integer' => 'int',
            'double' => 'float',
            'string' => 'string',
            'object' => 'object',
            default => $this->type,
        };
    }
}
