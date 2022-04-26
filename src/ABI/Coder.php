<?php

namespace Awuxtron\Web3\ABI;

use Awuxtron\Web3\Types\Arr;
use Awuxtron\Web3\Types\EthereumType;
use Awuxtron\Web3\Types\Integer;
use Awuxtron\Web3\Types\Tuple;
use Awuxtron\Web3\Utils\Hex;
use Brick\Math\BigInteger;
use InvalidArgumentException;

class Coder
{
    /**
     * Decode the data according to the array of types.
     *
     * @param array<mixed> $types
     * @param Hex|string   $data
     *
     * @return array<mixed>
     */
    public static function decode(array $types, string|Hex $data): array
    {
        /** @var EthereumType[] $types */
        $types = array_map([EthereumType::class, 'resolve'], $types);
        $data = Hex::of($data);

        $decoded = [];
        $dynamic = [];
        $position = BigInteger::zero();

        foreach ($types as $index => $type) {
            if ($type->isDynamic()) {
                $dynamic[$index] = [$type, $data->slice($position, $size = 32)->toInteger()];
                $decoded[$index] = null;
            } else {
                $decoded[$index] = $type->decode($data->slice($position, $size = $type->getBytesSize()));
            }

            $position = $position->plus($size);
        }

        $keys = array_keys($dynamic);
        $values = array_values($dynamic);

        foreach ($values as $i => $val) {
            $length = null;

            if (array_key_exists($i + 1, $values)) {
                $length = $values[$i + 1][1]->minus($val[1]);
            }

            if (!$val[0] instanceof Tuple && !$val[0] instanceof Arr) {
                $val[1] = $val[1]->plus(32);
                $length = $length?->minus(32);
            }

            $decoded[$keys[$i]] = $val[0]->decode($data->slice($val[1], $length));
        }

        return $decoded;
    }

    /**
     * Encode the array values according to the array of types.
     *
     * @param array<mixed> $types
     * @param array<mixed> $values
     * @param bool         $validate
     *
     * @return Hex
     */
    public static function encode(array $types, array $values, bool $validate = true): Hex
    {
        if ($validate && count($types) !== count($values)) {
            throw new InvalidArgumentException('The length of values must be same as types.');
        }

        /** @var EthereumType[] $types */
        $types = array_map([EthereumType::class, 'resolve'], $types);

        [$static, $dynamic, $emptyStr] = [[], [], str_repeat('ffff', 16)];

        foreach ($types as $i => $type) {
            $size = $type->getValueSize($values[$i]);
            $encoded = $type->encode($values[$i], $validate);

            if ($size !== null) {
                $encoded = $encoded->prepend((new Integer)->encode($size));
            }

            if ($type->isDynamic()) {
                $static[$i] = $emptyStr;
                $dynamic[$i] = $encoded;

                continue;
            }

            $static[$i] = $encoded;
        }

        // Calculator position for dynamic types.
        $position = strlen(implode('', $static)) / 2;

        foreach ($dynamic as $i => $v) {
            $static[$i] = (new Integer)->encode($position);
            $position += strlen($v) / 2;
        }

        return Hex::of(implode('', $static) . implode('', $dynamic));
    }
}
