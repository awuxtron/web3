<?php

namespace Awuxtron\Web3\Methods;

abstract class MethodNamespace
{
    use Extendable;

    /**
     * Prevent ide error.
     */
    public function __get(string $name): bool
    {
        return true;
    }

    /**
     * Prevent ide error.
     */
    public function __set(string $name, mixed $value): void
    {
    }

    /**
     * Prevent ide error.
     */
    public function __isset(string $name): bool
    {
        return true;
    }

    /**
     * Get the class namespace.
     */
    public static function getNamespace(): string
    {
        return static::class;
    }
}
