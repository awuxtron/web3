<?php

namespace Awuxtron\Web3\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class BigNumber implements CastsAttributes
{
    /**
     * Transform the attribute from the underlying model values.
     *
     * @param Model        $model
     * @param string       $key
     * @param mixed        $value
     * @param array<mixed> $attributes
     *
     * @return \Brick\Math\BigNumber
     */
    public function get($model, string $key, $value, array $attributes): \Brick\Math\BigNumber
    {
        return \Brick\Math\BigNumber::of($value);
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
        return (string) \Brick\Math\BigNumber::of($value);
    }
}
