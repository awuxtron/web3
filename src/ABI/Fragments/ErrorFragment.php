<?php

namespace Awuxtron\Web3\ABI\Fragments;

class ErrorFragment extends Fragment
{
    /**
     * Create a new error fragment instance.
     *
     * @param string       $name
     * @param array<mixed> $inputs
     */
    public function __construct(string $name, array $inputs = [])
    {
        parent::__construct('error', $name, $inputs);
    }

    /**
     * Create a new fragment instance from an abi or string.
     *
     * @param array<mixed>|string $input
     *
     * @return self
     */
    public static function from(string|array $input): self
    {
        if (is_string($input)) {
            [$name, $inputs] = static::parseFragmentString('error', $input);

            $input = [
                'name' => $name,
                'inputs' => static::parseTypes(substr($inputs, 0, -1)),
            ];
        }

        return new self($input['name'], $input['inputs'] ?? []);
    }
}
