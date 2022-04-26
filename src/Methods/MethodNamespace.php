<?php

namespace Awuxtron\Web3\Methods;

abstract class MethodNamespace
{
    use Extendable;

    /**
     * Get the class namespace.
     */
    public static function getNamespace(): string
    {
        return static::class;
    }
}
