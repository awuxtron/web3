<?php

namespace Awuxtron\Web3\Types;

use Awuxtron\Web3\Utils\Hex;
use InvalidArgumentException;

class LogFilter extends EthereumType
{
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
            return !$throw ? false : throw new InvalidArgumentException('The given value must be of type array.');
        }

        if (array_key_exists('fromBlock', $value) && !(new Block)->validate($value['fromBlock'], false)) {
            return !$throw ? false : throw new InvalidArgumentException('The parameter "fromBlock" must be a valid block.');
        }

        if (array_key_exists('toBlock', $value) && !(new Block)->validate($value['toBlock'], false)) {
            return !$throw ? false : throw new InvalidArgumentException('The parameter "toBlock" must be a valid block.');
        }

        if (array_key_exists('address', $value)) {
            if (!is_array($value['address'])) {
                $value['address'] = [$value['address']];
            }

            $validated = array_filter($value['address'], fn ($v) => (new Address)->validate($v, false));

            if (count($validated) != count($value['address'])) {
                return !$throw ? false : throw new InvalidArgumentException('The parameter "address" must be a valid address or array of addresses.');
            }
        }

        if (array_key_exists('topics', $value)) {
            if (!is_array($value['topics'])) {
                return !$throw ? false : throw new InvalidArgumentException('The parameter "topics" must be type of array.');
            }

            $validated = array_filter($value['topics'], fn ($v) => (new Bytes(32))->validate($v, false));

            if (count($validated) != count($value['topics'])) {
                return !$throw ? false : throw new InvalidArgumentException('The parameter "topics" must be a valid array of 32 bytes hex.');
            }
        }

        if (array_key_exists('blockhash', $value) && !(new Bytes(32))->validate($value['blockhash'], false)) {
            return !$throw ? false : throw new InvalidArgumentException('The parameter "blockhash" must be a valid 32 bytes hex.');
        }

        return true;
    }

    /**
     * Encodes value to its ABI representation.
     *
     * @param mixed $value
     * @param bool  $validate
     *
     * @return array<string, mixed>
     */
    public function encode(mixed $value, bool $validate = true): array
    {
        if ($validate) {
            $this->validate($value);
        }

        $value['fromBlock'] = (new Block)->encode($value['fromBlock'] ?? Block::LATEST);
        $value['toBlock'] = (new Block)->encode($value['toBlock'] ?? Block::LATEST);

        if (array_key_exists('address', $value)) {
            if (!is_array($value['address'])) {
                $value['address'] = [$value['address']];
            }

            $value['address'] = array_map(fn ($v) => Hex::of($v)->prefixed(), $value['address']);
        }

        if (array_key_exists('topics', $value)) {
            $value['topics'] = array_map(fn ($v) => Hex::of($v)->prefixed(), $value['topics']);
        }

        if (array_key_exists('blockhash', $value)) {
            $value['blockhash'] = Hex::of($value['blockhash'])->prefixed();
        }

        return $value;
    }

    /**
     * Decodes ABI encoded string to its Ethereum type.
     */
    public function decode(string|Hex $value): mixed
    {
        return null;
    }

    /**
     * Get the ethereum type name.
     */
    public function getName(): string
    {
        return 'log_filter';
    }
}
