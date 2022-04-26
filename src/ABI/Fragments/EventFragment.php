<?php

namespace Awuxtron\Web3\ABI\Fragments;

use Awuxtron\Web3\ABI\FormatTypes;
use Awuxtron\Web3\Utils\Hex;
use Awuxtron\Web3\Utils\Sha3;
use UnexpectedValueException;

class EventFragment extends Fragment
{
    /**
     * Create a new event instance.
     *
     * @param string       $name
     * @param array<mixed> $inputs
     * @param bool         $anonymous
     */
    public function __construct(string $name, array $inputs = [], protected bool $anonymous = false)
    {
        parent::__construct('event', $name, $inputs);
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
            [$name, $afterName] = static::parseFragmentString('event', $input);

            $anonymous = false;
            $afterName = trim($afterName);

            if (str_ends_with($afterName, 'anonymous')) {
                $anonymous = true;
                $afterName = trim(substr($afterName, 0, -9));
            }

            $input = [
                'name' => $name,
                'inputs' => static::parseTypes(substr($afterName, 0, -1)),
                'anonymous' => $anonymous,
            ];
        }

        return new self($input['name'], $input['inputs'] ?? [], $input['anonymous'] ?? false);
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
        return parent::format($format) . ($format != FormatTypes::SIGHASH && $this->anonymous ? ' anonymous' : '');
    }

    /**
     * Get the topic hash of the event.
     *
     * @return Hex
     */
    public function getTopic(): Hex
    {
        $result = Sha3::hash($this->format());

        if ($result == null) {
            throw new UnexpectedValueException('Unable to hash the event.');
        }

        return $result;
    }
}
