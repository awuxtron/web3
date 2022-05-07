<?php

namespace Awuxtron\Web3\Types;

use Awuxtron\Web3\Utils\Hex;

class Transaction extends Obj
{
    /**
     * Create a new transaction instance.
     */
    public function __construct()
    {
        $prefixed = fn (Hex $hex) => $hex->prefixed();

        parent::__construct([
            'from' => ['address?', null, $prefixed],
            'to' => ['address', null, $prefixed],
            'gas' => ['int?', null, $prefixed],
            'gasPrice' => ['int?', null, $prefixed],
            'nonce' => ['int?', null, $prefixed],
            'value' => ['int?', null, $prefixed],
            'data' => ['bytes?', null, $prefixed],
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
        return 'transaction';
    }
}
