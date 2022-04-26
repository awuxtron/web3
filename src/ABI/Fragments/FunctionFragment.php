<?php

namespace Awuxtron\Web3\ABI\Fragments;

use Awuxtron\Web3\ABI\FormatTypes;
use Awuxtron\Web3\ABI\ParamType;
use Awuxtron\Web3\Types\EthereumType;
use Awuxtron\Web3\Utils\Hex;
use Awuxtron\Web3\Utils\Sha3;
use InvalidArgumentException;
use UnexpectedValueException;

class FunctionFragment extends Fragment
{
    /**
     * The supported state mutabilities.
     *
     * @var string[]
     */
    protected static array $supportedStateMutabilities = [
        'pure',
        'view',
        'nonpayable',
        'payable',
    ];

    /**
     * The function outputs.
     *
     * @var ParamType[]
     */
    protected array $outputs;

    /**
     * Create a new function fragment instance.
     *
     * @param string       $name
     * @param array<mixed> $inputs
     * @param array<mixed> $outputs
     * @param string       $stateMutability
     */
    public function __construct(protected string $name, array $inputs = [], array $outputs = [], protected string $stateMutability = 'nonpayable')
    {
        parent::__construct('function', $name, $inputs);

        $this->outputs = array_map([ParamType::class, 'from'], $outputs);

        if (!in_array($stateMutability, static::$supportedStateMutabilities, true)) {
            throw new InvalidArgumentException(sprintf('Invalid state mutability: %s.', $stateMutability));
        }
    }

    /**
     * Encodes the function name to its ABI signature, which are the first 4 bytes of the sha3 hash of the function
     * name including types.
     *
     * @return Hex
     */
    public function getSignature(): Hex
    {
        $result = Sha3::hash($this->format());

        if ($result == null) {
            throw new UnexpectedValueException('Unable to hash the function.');
        }

        return $result->slice(0, 4);
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
            [$name, $afterName] = static::parseFragmentString('function', $input);

            $input = [
                'name' => $name,
            ];

            $parsed = explode_top_level(' ', "({$afterName}");

            // Get function inputs.
            if (!str_starts_with($parsed[0], '(') || !str_ends_with($parsed[0], ')')) {
                throw new InvalidArgumentException('Invalid function fragment string.');
            }

            $input['inputs'] = static::parseTypes(substr($parsed[0], 1, -1));

            // Get function state mutability.
            if (!empty($parsed[1]) && in_array($parsed[1], static::$supportedStateMutabilities, true)) {
                $input['stateMutability'] = $parsed[1];

                unset($parsed[1]);

                $parsed = array_values($parsed);
            }

            // Get function outputs.
            if (!empty($parsed[1]) && $parsed[1] == 'returns') {
                if (empty($parsed[2])) {
                    throw new InvalidArgumentException('Invalid function fragment string.');
                }

                $input['outputs'] = static::parseTypes(substr($parsed[2], 1, -1));
            }
        }

        return new self($input['name'], $input['inputs'] ?? [], $input['outputs'] ?? [], $input['stateMutability'] ?? 'nonpayable');
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
        $result = parent::format($format) . ' ';

        if ($format != FormatTypes::SIGHASH) {
            // Function state mutability.
            if ($this->stateMutability != 'nonpayable') {
                $result .= $this->stateMutability . ' ';
            }

            // Function outputs.
            if (!empty($this->outputs)) {
                $result .= 'returns (';
                $result .= $this->formatTypes($this->outputs, $format);
                $result .= ')';
            }
        }

        return trim($result);
    }

    /**
     * Get the fragment outputs.
     *
     * @return ParamType[]
     */
    public function getOutputs(): array
    {
        return $this->outputs;
    }

    /**
     * Get the output ETH types.
     *
     * @return EthereumType[]
     */
    public function getOutputTypes(): array
    {
        $result = [];
        $types = array_map(fn (ParamType $type) => EthereumType::resolve($type->format(FormatTypes::FULL)), $this->getOutputs());

        foreach ($types as $i => $type) {
            $result[$type->getParamName() ?: $i] = $type;
        }

        return $result;
    }
}
