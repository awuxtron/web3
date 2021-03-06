<?php

namespace Awuxtron\Web3\Types;

use Awuxtron\Web3\Utils\Hex;

class Filter extends Obj
{
    /**
     * Create a new transaction instance.
     */
    public function __construct()
    {
        $prefixed = fn (Hex $hex) => $hex->prefixed();

        parent::__construct([
            'fromBlock' => ['block', Block::LATEST],
            'toBlock' => ['block', Block::LATEST],
            'address' => ['address[]?', null, fn (array $v) => array_map($prefixed, $v)],
            'topics' => ['topics?', null],
            'blockhash' => ['bytes32?', null, $prefixed],
        ]);
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
        return parent::encode($value, $validate, false);
    }

    /**
     * Get the ethereum type name.
     */
    public function getName(): string
    {
        return 'filter';
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
        if (isset($value['address']) && !is_array($value['address'])) {
            $value['address'] = [$value['address']];
        }

        return parent::getValue($value);
    }
}
