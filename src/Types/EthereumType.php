<?php

namespace Awuxtron\Web3\Types;

use Brick\Math\BigInteger;
use InvalidArgumentException;

abstract class EthereumType
{
    /**
     * The list of supported type.
     *
     * @var array<string, class-string<EthereumType>>
     */
    protected static array $supportedTypes = [
        'address' => Address::class,
        'arr' => Arr::class,
        'array' => Arr::class,
        'block' => Block::class,
        'bool' => Boolean::class,
        'boolean' => Boolean::class,
        'bytes' => Bytes::class,
        'filter' => Filter::class,
        'fixed' => Fixed::class,
        'int' => Integer::class,
        'integer' => Integer::class,
        'obj' => Obj::class,
        'object' => Obj::class,
        'string' => Str::class,
        'topics' => Topics::class,
        'transaction' => Transaction::class,
        'tuple' => Tuple::class,
        'whisper' => Whisper::class,
    ];

    /**
     * The regex pattern for matching a solidity type.
     */
    protected static string $pattern = '/^(?<type1>address|bool|function|string)$|^((?<type2>bytes|((?<unsigned>u)?(?<type3>int|fixed)))(?<bytes>[\d]|[1-9][\d]|1[\d]{2}|2[0-4][\d]|25[0-6])?(x(?<decimals>[\d]|[1-7][\d]|80))?)$/i';

    /**
     * The parameter name.
     *
     * @var null|string
     */
    protected ?string $paramName;

    /**
     * Get an ethereum type object from type string.
     */
    final public static function resolve(self|string $type): self
    {
        if ($type instanceof self) {
            return $type;
        }

        if ($type == '') {
            throw new InvalidArgumentException('Invalid type.');
        }

        $type = preg_replace('/\s+/', ' ', $type) ?: $type;

        if (array_key_exists($type, static::$supportedTypes)) {
            return new static::$supportedTypes[$type];
        }

        [$type, $paramName] = static::parseParamName($type);

        if (static::isArray($type)) {
            $type = static::resolveArrayType($type);
        } elseif (static::isTuple($type)) {
            $type = static::resolveTupleType($type);
        }

        [$name, $arguments] = static::parseTypeString($type);

        if (!is_subclass_of($name, static::class)) {
            if (!array_key_exists($name, static::$supportedTypes)) {
                throw new InvalidArgumentException(sprintf('Unsupported type: %s', $name));
            }

            $name = static::$supportedTypes[$name];
        }

        /** @var static $class */
        $class = new $name(...$arguments);

        return $class->setParamName($paramName);
    }

    /**
     * Determine if the current type is dynamic.
     */
    abstract public function isDynamic(): bool;

    /**
     * Validate the value is valid.
     *
     * @param mixed $value the value needs to be validated
     * @param bool  $throw throw an exception when validation returns false
     */
    abstract public function validate(mixed $value, bool $throw = true): bool;

    /**
     * Encodes value to its ABI representation.
     */
    abstract public function encode(mixed $value, bool $validate = true, bool $pad = true): mixed;

    /**
     * Decodes ABI encoded string to its Ethereum type.
     */
    abstract public function decode(mixed $value): mixed;

    /**
     * Validate and return validated value.
     *
     * @template T
     *
     * @param T $value
     *
     * @return T
     */
    public function validated(mixed $value): mixed
    {
        $this->validate($value);

        return $value;
    }

    /**
     * Get size of the value for dynamic-type.
     */
    public function getValueSize(mixed $value): ?int
    {
        return null;
    }

    /**
     * Get the ethereum type name.
     */
    abstract public function getName(): string;

    /**
     * Get the bytes size of encoded hex string.
     *
     * @return BigInteger
     */
    public function getBytesSize(): BigInteger
    {
        return BigInteger::of(32);
    }

    /**
     * Set the param name.
     *
     * @param null|string $name
     *
     * @return static
     */
    public function setParamName(?string $name): static
    {
        $this->paramName = $name;

        return $this;
    }

    /**
     * Get the param name.
     *
     * @return null|string
     */
    public function getParamName(): ?string
    {
        return $this->paramName ?? null;
    }

    /**
     * Get the ethereum type name include param name.
     *
     * @return string
     */
    public function getNameWithParamName(): string
    {
        return trim($this->getName() . ' ' . $this->getParamName());
    }

    /**
     * Determine if the given type is array-type.
     */
    protected static function isArray(string $type): bool
    {
        return str_ends_with($type, ']');
    }

    /**
     * Determine if the given type is tuple-type.
     */
    protected static function isTuple(string $type): bool
    {
        $tupleCount = substr_count($type, 'tuple');
        $openParentheses = substr_count($type, '(');
        $closeParentheses = substr_count($type, ')');

        return
            str_starts_with($type, 'tuple(')
            && str_ends_with($type, ')')
            && $tupleCount === $openParentheses
            && $tupleCount === $closeParentheses;
    }

    /**
     * Resolve the type of array from the given type.
     */
    protected static function resolveArrayType(string $type): string
    {
        $name = preg_replace('/\[(\d+)?]$/', '', $type, 1);
        $length = static::getArrayLength($type);

        return 'array:' . $name . ($length !== null ? ",{$length}" : '');
    }

    /**
     * Resolve types of tuple from the given type.
     */
    protected static function resolveTupleType(string $type): string
    {
        return substr(substr_replace($type, ':', 5, 1), 0, -1);
    }

    /**
     * Get the length of the array from the given type.
     */
    protected static function getArrayLength(string $type): ?int
    {
        if (str_ends_with($type, '[]')) {
            return null;
        }

        preg_match('/\[(\d+)]$/', $type, $matches);

        return $matches[1];
    }

    /**
     * Parse the given string into a type and arguments.
     *
     * @param string $type
     *
     * @return array<mixed>
     */
    protected static function parseTypeString(string $type): array
    {
        $segments = explode(':', $type, 2);

        if (!empty($segments[1])) {
            return [$segments[0], array_map('trim', explode_top_level(',', $segments[1]))];
        }

        preg_match(static::$pattern, $segments[0], $matches);

        if (!$matches) {
            return [$segments[0], []];
        }

        if (!empty($matches['type3'])) {
            $matches['type2'] = $matches['type3'];
        }

        return [
            $matches['type1'] ?: $matches['type2'],
            [
                $matches['bytes'] ?? null,
                !empty($matches['unsigned']),
                $matches['decimals'] ?? null,
            ],
        ];
    }

    /**
     * Parse the type string to get param name.
     *
     * @param string $type
     *
     * @return array{string, ?string}
     */
    protected static function parseParamName(string $type): array
    {
        $name = null;
        $result = explode_top_level(' ', $type);

        if (!empty($result[1])) {
            $name = trim($result[1]);
        }

        return [trim($result[0]), $name];
    }

    /**
     * Throw an exception or false if $throw set to false.
     *
     * @param mixed $exception
     * @param bool  $throw
     *
     * @return bool
     */
    protected function throw(mixed $exception, bool $throw): bool
    {
        return !$throw ? false : throw $exception;
    }
}
