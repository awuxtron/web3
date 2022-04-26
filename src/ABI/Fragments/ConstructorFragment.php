<?php

namespace Awuxtron\Web3\ABI\Fragments;

use Awuxtron\Web3\ABI\FormatTypes;
use InvalidArgumentException;

class ConstructorFragment extends Fragment
{
    /**
     * The supported state mutabilities.
     *
     * @var string[]
     */
    protected static array $supportedStateMutabilities = [
        'nonpayable',
        'payable',
    ];

    /**
     * Create a new constructor instance.
     *
     * @param array<mixed> $inputs
     * @param string       $stateMutability
     */
    public function __construct(array $inputs = [], protected string $stateMutability = 'nonpayable')
    {
        parent::__construct('constructor', '', $inputs);

        if (!in_array($stateMutability, static::$supportedStateMutabilities, true)) {
            throw new InvalidArgumentException(sprintf('Invalid state mutability: %s.', $stateMutability));
        }
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
            $input = trim($input);

            if (!str_starts_with($input, 'constructor(') || !str_ends_with($input, ')')) {
                throw new InvalidArgumentException('Invalid constructor type string.');
            }

            $input = [
                'inputs' => static::parseTypes(substr($input, 12, -1)),
            ];
        }

        return new self($input['inputs'] ?? [], $input['stateMutability'] ?? 'nonpayable');
    }

    /**
     * Format the fragment.
     *
     * @param FormatTypes $format
     *
     * @return string
     */
    public function format(FormatTypes $format = FormatTypes::MINIMAL): string
    {
        if ($format == FormatTypes::SIGHASH) {
            throw new InvalidArgumentException('Unable to format a constructor as sighash.');
        }

        $result = $this->type . '(' . $this->formatTypes($this->inputs, $format) . ')';

        if ($this->stateMutability != 'nonpayable') {
            $result .= ' ' . $this->stateMutability;
        }

        return $result;
    }
}
