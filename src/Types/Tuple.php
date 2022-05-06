<?php

namespace Awuxtron\Web3\Types;

use Awuxtron\Web3\ABI\Coder;
use Awuxtron\Web3\Utils\Hex;
use InvalidArgumentException;

class Tuple extends EthereumType
{
    /**
     * The array of types in tuple.
     *
     * @var EthereumType[]
     */
    protected array $types;

    /**
     * Create a new tuple type object.
     *
     * @param EthereumType|string ...$types
     */
    public function __construct(string|EthereumType ...$types)
    {
        $this->types = array_map(static fn ($type) => EthereumType::resolve($type), $types);
    }

    /**
     * Determine if the current type is dynamic.
     */
    public function isDynamic(): bool
    {
        foreach ($this->types as $type) {
            if ($type->isDynamic()) {
                return true;
            }
        }

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
        if (!is_array($value) || count($value) !== count($this->types)) {
            return !$throw ? false : throw new InvalidArgumentException('The value is not a valid array.');
        }

        foreach ($this->types as $i => $type) {
            if (!$type->validate($value[$i], $throw)) {
                return false;
            }
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

        return Coder::encode($this->types, $value, false);
    }

    /**
     * Decodes ABI encoded string to its Ethereum type.
     *
     * @param Hex|string $value
     *
     * @return array<mixed>
     */
    public function decode(string|Hex $value): array
    {
        return Coder::decode($this->getTypeWithParamName(), $value);
    }

    /**
     * Get the ethereum type name.
     */
    public function getName(bool $withParamName = false): string
    {
        return 'tuple(' . implode(', ', array_map(static fn (EthereumType $type) => $withParamName ? $type->getNameWithParamName() : $type->getName(), $this->types)) . ')';
    }

    /**
     * Get the ethereum type name include param name.
     *
     * @return string
     */
    public function getNameWithParamName(): string
    {
        return trim($this->getName(true) . ' ' . $this->getParamName());
    }

    /**
     * Get the tuple types.
     *
     * @return EthereumType[]
     */
    public function getTypes(): array
    {
        return $this->types;
    }

    /**
     * Get the tuple type array with key is param name.
     *
     * @return EthereumType[]
     */
    protected function getTypeWithParamName(): array
    {
        $types = [];

        foreach ($this->types as $i => $type) {
            $types[$type->getParamName() ?: $i] = $type;
        }

        return $types;
    }
}
