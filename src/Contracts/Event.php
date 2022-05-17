<?php

namespace Awuxtron\Web3\Contracts;

use Awuxtron\Web3\ABI\Fragments\EventFragment;
use Awuxtron\Web3\Utils\Hex;

class Event
{
    /**
     * The array of event fragments.
     *
     * @var EventFragment[]
     */
    protected array $events;

    /**
     * Create a new contract event instance.
     *
     * @param Contract     $contract
     * @param null|string  $name
     * @param array<mixed> $options
     */
    public function __construct(protected Contract $contract, ?string $name = null, protected array $options = [])
    {
        if (!empty($name)) {
            $this->events = [$name => $contract->getInterface()->getEvent($name)];
        } else {
            $this->events = $contract->getInterface()->getEvents();
        }
    }

    /**
     * Get all logs by events.
     *
     * @param array<mixed> $options
     *
     * @return array<mixed>
     */
    public function get(array $options = []): array
    {
        return $this->contract->getWeb3()->eth()->getLogs($this->getFilter($options))->value();
    }

    /**
     * Get event topics.
     *
     * @return Hex[]
     */
    public function getTopics(): array
    {
        return array_map(fn (EventFragment $fragment) => $fragment->getTopic(), $this->events);
    }

    /**
     * Get the filter object.
     *
     * @param array<mixed> $options
     *
     * @return array<mixed>
     */
    protected function getFilter(array $options = []): array
    {
        $options = array_merge($this->options, $options);
        $topics = $this->getTopics();

        if (empty($options['topics'])) {
            $options['topics'] = [array_values($topics)];
        }

        if (is_callable($options['topics'])) {
            $options['topics'] = $options['topics']($topics);
        }

        return array_merge($this->options, $options, [
            'address' => [$this->contract->getAddress()],
        ]);
    }
}
