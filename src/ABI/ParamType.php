<?php

namespace Awuxtron\Web3\ABI;

use Awuxtron\Web3\Types\Arr;
use Awuxtron\Web3\Types\EthereumType;
use Awuxtron\Web3\Types\Tuple;
use InvalidArgumentException;
use JsonSerializable;

class ParamType implements JsonSerializable
{
    /**
     * The param components (only on tuple).
     *
     * @var static[]
     */
    protected array $components = [];

    /**
     * Create a new param type instance.
     *
     * @param string       $name
     * @param string       $type
     * @param array<mixed> $components
     * @param null|bool    $indexed
     */
    final public function __construct(protected string $type, protected string $name = '', array $components = [], protected ?bool $indexed = null)
    {
        if (empty($components) && str_starts_with($type, 'tuple')) {
            throw new InvalidArgumentException('The components must be specified for tuple type.');
        }

        $this->components = array_map([static::class, 'from'], $components);
    }

    /**
     * Convert an array to param type object.
     *
     * @param array{type: string, name?: string, components?: array<mixed>, indexed?: boolean}|self|string $input
     *
     * @return static
     */
    public static function from(string|self|array $input): static
    {
        if ($input instanceof static) {
            return $input;
        }

        if (is_string($input)) {
            $input = preg_replace('/\s+/', ' ', $input) ?: $input;
            $input = str_replace(['tuple(', ' indexed '], ['(', ' indexed-'], $input);
            $type = EthereumType::resolve(str_replace('(', 'tuple(', $input));

            $input = [
                'type' => $type->getName(),
            ];

            $parse = explode('-', (string) $type->getParamName());

            if (count($parse) > 1) {
                $input['name'] = $parse[1];
                $input['indexed'] = trim($parse[0]) == 'indexed';
            } else {
                $input['name'] = $parse[0];
            }

            if ($type instanceof Arr) {
                $resolve = $type->getExactType();

                if ($resolve instanceof Tuple) {
                    $input['type'] = 'tuple' . last(explode(')', $input['type']));
                    $input['components'] = static::getTupleComponents($resolve);
                }
            }

            if ($type instanceof Tuple) {
                $input['type'] = 'tuple';
                $input['components'] = static::getTupleComponents($type);
            }
        }

        // @phpstan-ignore-next-line
        return new static($input['type'], $input['name'] ?? '', $input['components'] ?? [], $input['indexed'] ?? null);
    }

    /**
     * Format the parameter fragment.
     *    - sighash: "(uint256,address)"
     *    - minimal: "tuple(uint256,address) indexed"
     *    - full:    "tuple(uint256 foo, address bar) indexed baz".
     *
     * @param FormatTypes $format
     *
     * @return string
     */
    public function format(FormatTypes $format = FormatTypes::SIGHASH): string
    {
        $this->indexed = (bool) $this->indexed;

        if (str_starts_with($this->type, 'tuple')) {
            $result = '(' . implode(',' . ($format == FormatTypes::FULL ? ' ' : ''), array_map(static fn (ParamType $component) => $component->format($format), $this->components)) . ')';
            $result .= substr($this->type, 5);

            if ($format != FormatTypes::SIGHASH) {
                $result = 'tuple' . $result . ' ' . ($this->indexed ? 'indexed ' : '') . $this->name;
            }

            return trim($result);
        }

        $type = EthereumType::resolve($this->type . ' ' . ($this->indexed ? 'indexed-' : '') . $this->name);

        $result = match ($format) {
            FormatTypes::SIGHASH => $type->getName(),
            FormatTypes::MINIMAL => $type->getName() . ($this->indexed ? ' indexed' : ''),
            default => $type->getNameWithParamName()
        };

        return trim(str_replace('indexed-', 'indexed ', $result));
    }

    /**
     * Convert the param type object to array.
     *
     * @return array<mixed>
     */
    public function toArray(): array
    {
        $result = [
            'type' => $this->type,
            'name' => $this->name,
        ];

        if ($this->indexed !== null) {
            $result['indexed'] = $this->indexed;
        }

        if (!empty($this->components)) {
            $result['components'] = array_map(static fn (ParamType $component) => $component->toArray(), $this->components);
        }

        return $result;
    }

    /**
     * @return array<mixed>
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    /**
     * Get the array of tuple components.
     *
     * @param Tuple $tuple
     *
     * @return string[]
     */
    protected static function getTupleComponents(Tuple $tuple): array
    {
        return array_map(static fn (EthereumType $type) => $type->getNameWithParamName(), $tuple->getTypes());
    }
}
