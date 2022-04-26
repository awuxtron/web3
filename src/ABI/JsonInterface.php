<?php

namespace Awuxtron\Web3\ABI;

use Awuxtron\Web3\ABI\Fragments\ConstructorFragment;
use Awuxtron\Web3\ABI\Fragments\ErrorFragment;
use Awuxtron\Web3\ABI\Fragments\EventFragment;
use Awuxtron\Web3\ABI\Fragments\Fragment;
use Awuxtron\Web3\ABI\Fragments\FunctionFragment;
use InvalidArgumentException;
use JsonException;
use JsonSerializable;
use LogicException;

class JsonInterface implements JsonSerializable
{
    /**
     * The array of function fragments.
     *
     * @var FunctionFragment[]
     */
    protected array $functions = [];

    /**
     * The array of event fragments.
     *
     * @var EventFragment[]
     */
    protected array $events = [];

    /**
     * The array of error fragments.
     *
     * @var ErrorFragment[]
     */
    protected array $errors = [];

    /**
     * The constructor fragment.
     *
     * @var ConstructorFragment
     */
    protected ConstructorFragment $constructor;

    /**
     * Create a new json interface instance.
     *
     * @param array<int,mixed> $abi
     */
    final public function __construct(protected array $abi)
    {
        foreach ($abi as $item) {
            $this->addFragment(Fragment::from($item));
        }
    }

    /**
     * @throws JsonException
     */
    public function __toString(): string
    {
        return json_encode($this->jsonSerialize(), JSON_THROW_ON_ERROR);
    }

    /**
     * Get the constructor.
     *
     * @return null|ConstructorFragment
     */
    public function getConstructor(): ?ConstructorFragment
    {
        return $this->constructor ?? null;
    }

    /**
     * Get the error by name.
     *
     * @param string $name
     *
     * @return ErrorFragment
     */
    public function getError(string $name): ErrorFragment
    {
        if (!array_key_exists($name, $this->errors)) {
            throw new InvalidArgumentException(sprintf('Error not found: %s.', $name));
        }

        return $this->errors[$name];
    }

    /**
     * Get the event by name.
     *
     * @param string $name
     *
     * @return EventFragment
     */
    public function getEvent(string $name): EventFragment
    {
        if (!array_key_exists($name, $this->events)) {
            throw new InvalidArgumentException(sprintf('Event not found: %s.', $name));
        }

        return $this->events[$name];
    }

    /**
     * Get the function by name.
     *
     * @param string $name
     *
     * @return FunctionFragment
     */
    public function getFunction(string $name): FunctionFragment
    {
        if (!array_key_exists($name, $this->functions)) {
            throw new InvalidArgumentException(sprintf('Function not found: %s.', $name));
        }

        return $this->functions[$name];
    }

    /**
     * Format the json interface.
     *
     * @param FormatTypes $format
     *
     * @return string[]
     */
    public function format(FormatTypes $format): array
    {
        if ($format == FormatTypes::SIGHASH) {
            throw new InvalidArgumentException('Unable to format a json interface as sighash.');
        }

        $formatter = static function (Fragment $fragment) use ($format) {
            return $fragment->format($format);
        };

        return array_map($formatter, $this->getFragments());
    }

    /**
     * Add a fragment to the json interface instance.
     *
     * @param Fragment $fragment
     *
     * @return $this
     */
    public function addFragment(Fragment $fragment): static
    {
        if ($fragment instanceof ConstructorFragment) {
            if (!empty($this->constructor)) {
                throw new InvalidArgumentException('The constructor already exists on this interface.');
            }

            $this->constructor = $fragment;

            return $this;
        }

        $name = $fragment->getName();

        $type = match (get_class($fragment)) {
            ErrorFragment::class => 'errors',
            EventFragment::class => 'events',
            FunctionFragment::class => 'functions',
            default => throw new LogicException('Unsupported fragment.')
        };

        // @phpstan-ignore-next-line
        if (array_key_exists($name, $this->{$type})) {
            throw new InvalidArgumentException(sprintf('The fragment %s already exists.', $name));
        }

        $this->{$type}[$name] = $fragment; // @phpstan-ignore-line

        return $this;
    }

    /**
     * Get the list of all fragments contains in this instance.
     *
     * @return Fragment[]
     */
    public function getFragments(): array
    {
        return array_values(array_filter([
            $this->constructor ?? null,
            ...array_values($this->events),
            ...array_values($this->errors),
            ...array_values($this->functions),
        ]));
    }

    /**
     * Converts the json interface object to array.
     *
     * @return array<mixed>
     */
    public function toArray(): array
    {
        return array_map(static fn (Fragment $fragment) => $fragment->toArray(), $this->getFragments());
    }

    /**
     * @return array<mixed>
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    /**
     * Create a new json interface instance from abi.
     *
     * @param array<mixed>|self|string $abi
     *
     * @throws JsonException
     *
     * @return static
     */
    public static function from(self|string|array $abi): static
    {
        if ($abi instanceof static) {
            return $abi;
        }

        if (is_string($abi)) {
            $abi = json_decode($abi, true, 512, JSON_THROW_ON_ERROR);
        }

        return new static($abi);
    }
}
