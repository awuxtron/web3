<?php

namespace Awuxtron\Web3\ABI\Fragments;

use Awuxtron\Web3\ABI\FormatTypes;
use Awuxtron\Web3\ABI\ParamType;
use Awuxtron\Web3\Types\EthereumType;
use InvalidArgumentException;
use JsonSerializable;

abstract class Fragment implements JsonSerializable
{
    /**
     * The supported fragment types.
     *
     * @var string[]
     */
    protected static array $supportedTypes = ['function', 'event', 'constructor', 'error'];

    /**
     * The fragment inputs.
     *
     * @var ParamType[]
     */
    protected array $inputs;

    /**
     * Create a new fragment instance.
     *
     * @param string       $type
     * @param string       $name
     * @param array<mixed> $inputs
     */
    public function __construct(protected string $type, protected string $name, array $inputs)
    {
        if (!in_array($type, static::$supportedTypes, true)) {
            throw new InvalidArgumentException(sprintf('Unsupported type: %s.', $type));
        }

        $this->inputs = array_map([ParamType::class, 'from'], $inputs);
    }

    /**
     * Format the fragment.
     *
     * @param FormatTypes $format
     *
     * @return string
     */
    public function format(FormatTypes $format = FormatTypes::SIGHASH): string
    {
        $result = '';

        if ($format != FormatTypes::SIGHASH) {
            $result .= $this->type . ' ';
        }

        // Fragment name and arguments.
        $result .= $this->name . '(';
        $result .= $this->formatTypes($this->inputs, $format);
        $result .= ')';

        return $result;
    }

    /**
     * Converts the fragment object to array.
     *
     * @return array<mixed>
     */
    public function toArray(): array
    {
        $params = function (ParamType $type) {
            $t = $type->toArray();

            if ($this instanceof EventFragment) {
                $t['indexed'] ??= false;
            } else {
                unset($t['indexed']);
            }

            return $t;
        };

        $result = [
            'type' => $this->type,
            'inputs' => array_map($params, $this->inputs),
        ];

        if (!$this instanceof ConstructorFragment) {
            $result['name'] = $this->name;
        }

        if ($this instanceof FunctionFragment) {
            $result['outputs'] = array_map($params, $this->outputs);
            $result['stateMutability'] = $this->stateMutability;
        }

        if ($this instanceof EventFragment) {
            $result['anonymous'] = $this->anonymous;
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
     * Create a new fragment instance from an abi or string.
     *
     * @param array<mixed>|string $input
     *
     * @return Fragment
     */
    public static function from(string|array $input): Fragment
    {
        $type = 'function';

        if (is_string($input)) {
            $type = explode(' ', trim(explode('(', $input, 2)[0]), 2)[0];
        }

        /** @var array<mixed> $input */
        if (!empty($input['type'])) {
            $type = $input['type'];
        }

        return match ($type) {
            'constructor' => ConstructorFragment::from($input),
            'error' => ErrorFragment::from($input),
            'event' => EventFragment::from($input),
            default => FunctionFragment::from($input),
        };
    }

    /**
     * Get the fragment inputs.
     *
     * @return ParamType[]
     */
    public function getInputs(): array
    {
        return $this->inputs;
    }

    /**
     * Get the fragment ETH types.
     *
     * @return EthereumType[]
     */
    public function getInputTypes(): array
    {
        return array_map(fn (ParamType $type) => EthereumType::resolve($type->format(FormatTypes::FULL)), $this->getInputs());
    }

    /**
     * Get the name of the fragment.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Parse the string to get the list of types.
     *
     * @param string $types
     *
     * @return string[]
     */
    protected static function parseTypes(string $types): array
    {
        if (empty($types)) {
            return [];
        }

        return array_map('trim', explode_top_level(',', $types));
    }

    /**
     * Parse the string into two part (name and after name).
     *
     * @param string $fragment
     * @param string $input
     *
     * @return array<mixed>
     */
    protected static function parseFragmentString(string $fragment, string $input): array
    {
        $input = trim($input);

        [$name, $afterName] = explode('(', $input, 2);

        if (empty($name)) {
            throw new InvalidArgumentException("Missing {$fragment} name.");
        }

        $parsed = explode(' ', $name, 2);

        if (count($parsed) == 2) {
            if (trim($parsed[0]) != $fragment) {
                throw new InvalidArgumentException(sprintf('%s is not an %s fragment.', $input, $fragment));
            }

            $name = $parsed[1];
        }

        return [$name, $afterName];
    }

    /**
     * Format array of types to string.
     *
     * @param ParamType[] $types
     * @param FormatTypes $format
     *
     * @return string
     */
    protected function formatTypes(array $types, FormatTypes $format): string
    {
        $separator = ',' . ($format == FormatTypes::FULL ? ' ' : '');
        $formatter = static fn (ParamType $type) => $type->format($format);

        return implode($separator, array_map($formatter, $types));
    }
}
