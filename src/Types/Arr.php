<?php

namespace Awuxtron\Web3\Types;

use Awuxtron\Web3\ABI\Coder;
use Awuxtron\Web3\Utils\Hex;
use Brick\Math\BigInteger;
use InvalidArgumentException;

class Arr extends EthereumType
{
    /**
     * The type of array.
     */
    protected EthereumType $type;

    /**
     * Create a new array type object.
     *
     * @param mixed    $type   the type of array
     * @param null|int $length the length of array, use null for the dynamic array
     */
    public function __construct(mixed $type, public ?int $length = null)
    {
        $this->type = static::resolve($type);
    }

    /**
     * Determine if the current type is dynamic.
     */
    public function isDynamic(): bool
    {
        if ($this->length === null) {
            return true;
        }

        return $this->type->isDynamic();
    }

    /**
     * Validate the value is valid.
     *
     * @param mixed $value the value needs to be validated
     * @param bool  $throw throw an exception when validation returns false
     */
    public function validate(mixed $value, bool $throw = true): bool
    {
        if (!is_array($value) || ($this->length !== null && count($value) !== $this->length)) {
            return !$throw ? false : throw new InvalidArgumentException('The value is not a valid array.');
        }

        foreach ($value as $val) {
            if (!$this->type->validate($val, $throw)) {
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

        return Coder::encode(array_fill(0, count($value), $this->type), $value, false);
    }

    /**
     * Get size of the value for dynamic-type.
     */
    public function getValueSize(mixed $value): ?int
    {
        if ($this->length != null) {
            return null;
        }

        return count($value);
    }

    /**
     * Get the bytes size of encoded hex string.
     *
     * @return BigInteger
     */
    public function getBytesSize(): BigInteger
    {
        return BigInteger::of(32 * ($this->length ?? 0));
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
        $value = Hex::of($value);

        if ($this->length != null) {
            $length = BigInteger::of($this->length);
        } else {
            $length = $value->slice(0, 32)->toInteger();
            $value = $value->slice(32);
        }

        return Coder::decode(array_fill(0, $length->toInt(), $this->type), $value);
    }

    /**
     * Get the ethereum type name.
     */
    public function getName(bool $withParamName = false): string
    {
        return ($withParamName ? $this->type->getNameWithParamName() : $this->type->getName()) . "[{$this->length}]";
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
     * Get the type of the array.
     *
     * @return EthereumType
     */
    public function getType(): EthereumType
    {
        return $this->type;
    }

    /**
     * Get the exact type of the array.
     *
     * @return EthereumType
     */
    public function getExactType(): EthereumType
    {
        return $this->getTypeRecursive($this->getType());
    }

    /**
     * Get the exact type using recursive.
     *
     * @param EthereumType $type
     *
     * @return EthereumType
     */
    protected function getTypeRecursive(EthereumType $type): EthereumType
    {
        if ($type instanceof self) {
            return $this->getTypeRecursive($type->getType());
        }

        return $type;
    }
}
