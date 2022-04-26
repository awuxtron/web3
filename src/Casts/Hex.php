<?php

namespace Awuxtron\Web3\Casts;

use Awuxtron\Web3\Utils\Hex as HexUtil;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class Hex implements CastsAttributes
{
    /**
     * Transform the attribute from the underlying model values.
     *
     * @param Model        $model
     * @param string       $key
     * @param mixed        $value
     * @param array<mixed> $attributes
     *
     * @return HexUtil
     */
    public function get($model, string $key, $value, array $attributes): HexUtil
    {
        if (empty($value)) {
            return $value;
        }

        return HexUtil::of($value);
    }

    /**
     * Transform the attribute to its underlying model values.
     *
     * @param Model        $model
     * @param string       $key
     * @param mixed        $value
     * @param array<mixed> $attributes
     *
     * @return string
     */
    public function set($model, string $key, $value, array $attributes): string
    {
        if (empty($value)) {
            return $value;
        }

        return HexUtil::of($value)->lower()->prefixed();
    }
}
