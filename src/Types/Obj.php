<?php

namespace Awuxtron\Web3\Types;

use Exception;
use InvalidArgumentException;

class Obj extends EthereumType
{
    /**
     * The object structure.
     *
     * @var array<string, array{type: EthereumType, required: bool, default: mixed, encoder: callable, decoder: callable}>
     */
    protected array $structure = [];

    /**
     * Create a new object type instance.
     *
     * @param array<mixed>|string ...$structure
     */
    public function __construct(array|string ...$structure)
    {
        foreach ($structure as $item) {
            if (is_string($item)) {
                $default = null;
                $parsed = explode(':', str_replace_first('_', ':', trim($item)), 2);

                if (count($parsed) != 2) {
                    throw new InvalidArgumentException("{$item} is not a valid object structure string.");
                }

                $parsedType = explode('=', $parsed[1], 2);

                if (!empty($parsedType[1])) {
                    $default = substr(substr($parsedType[1], 0, -1), 1);
                }

                $item = [
                    $parsed[0] => [$parsedType[0], $default],
                ];
            }

            foreach ($item as $name => $type) {
                $default = null;
                $encoder = $decoder = fn ($v) => $v;

                if (is_array($type)) {
                    $default = $type[1] ?? null;
                    $encoder = $type[2] ?? $encoder;
                    $decoder = $type[3] ?? $decoder;
                    $type = $type[0];
                }

                $type = trim($type);
                $optional = false;

                if (str_ends_with($type, '?')) {
                    $optional = true;
                    $type = substr($type, 0, -1);
                }

                $type = EthereumType::resolve(trim($type));

                if (is_string($default) && ($type instanceof Arr || $type instanceof Tuple || $type instanceof Obj)) {
                    $default = json_decode(
                        (string) base64_decode($default, true),
                        true,
                        JSON_THROW_ON_ERROR | JSON_BIGINT_AS_STRING
                    );

                    if ($default == null) {
                        $optional = false;
                    }
                }

                $this->structure[$name] = [
                    'type' => $type,
                    'required' => !$optional,
                    'default' => $default,
                    'encoder' => $encoder,
                    'decoder' => $decoder,
                ];
            }
        }
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
        if (!is_array($value)) {
            return $this->throw(new InvalidArgumentException('The value must be of type array.'), $throw);
        }

        $value = $this->getValue($value);

        $required = array_filter($this->structure, fn ($item) => $item['required']);

        if (count($diff = array_diff_key($required, $value)) > 0) {
            return $this->throw(
                new InvalidArgumentException(sprintf('Missing keys: %s.', implode(', ', array_keys($diff)))),
                $throw
            );
        }

        foreach ($this->structure as $key => $item) {
            if (!$item['required'] && !isset($value[$key])) {
                if ($item['default'] === null) {
                    continue;
                }

                $value[$key] = $item['default'];
            }

            try {
                $item['type']->validate($value[$key]);
            } catch (Exception $e) {
                return $this->throw(
                    new InvalidArgumentException(sprintf('Invalid element %s: %s', $key, $e->getMessage())),
                    $throw
                );
            }
        }

        return true;
    }

    /**
     * Encodes value to its ABI representation.
     *
     * @param mixed $value
     * @param bool  $validate
     * @param bool  $pad
     *
     * @return array<string, mixed>
     */
    public function encode(mixed $value, bool $validate = true, bool $pad = true): array
    {
        if ($validate) {
            $this->validate($value);
        }

        $encoded = [];
        $value = $this->getValue($value);

        foreach ($this->structure as $name => $item) {
            if (!$item['required'] && !isset($value[$name])) {
                if ($item['default'] === null) {
                    continue;
                }

                $value[$name] = $item['default'];
            }

            $func = 'encode';

            if (method_exists($item['type'], 'encodeToArray')) {
                $func = 'encodeToArray';
            }

            $encoded[$name] = $item['encoder'](call_user_func_array([$item['type'], $func], [
                $value[$name],
                false,
                $pad,
            ]));
        }

        return $encoded;
    }

    /**
     * Decodes ABI encoded string to its Ethereum type.
     *
     * @param mixed $value
     *
     * @return array<string, mixed>
     */
    public function decode(mixed $value): array
    {
        $decoded = [];
        $value = $this->getValue($value);

        foreach ($this->structure as $name => $item) {
            if (!$item['required'] && !isset($value[$name])) {
                $value[$name] = $item['default'];
            }

            if ($value[$name] === null) {
                if ($item['required']) {
                    throw new InvalidArgumentException("Element: {$name} is required.");
                }

                $decoded[$name] = null;

                continue;
            }

            $decoded[$name] = $item['decoder']($item['type']->decode($value[$name]));
        }

        return $decoded;
    }

    /**
     * Get the ethereum type name.
     */
    public function getName(): string
    {
        $result = [];

        foreach ($this->structure as $key => $item) {
            $name = $key . '_' . $item['type']->getName() . (!$item['required'] ? '?' : '');

            if ($item['default'] != null) {
                if (is_array($item['default'])) {
                    $item['default'] = base64_encode(json_encode($item['default'], JSON_THROW_ON_ERROR));
                }

                $name .= '=(' . $item['default'] . ')';
            }

            $result[] = $name;
        }

        return 'object:' . implode(',', $result);
    }

    /**
     * Get the object value.
     *
     * @param array<mixed> $value
     *
     * @return array<mixed>
     */
    protected function getValue(array $value): array
    {
        $structure = array_map(fn ($item) => $item['default'], array_filter($this->structure, function ($item) {
            return $item['required'] && $item['default'] !== null;
        }));

        return array_merge(array_diff_key($structure, $value), $value);
    }
}
