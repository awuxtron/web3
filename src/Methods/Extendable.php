<?php

namespace Awuxtron\Web3\Methods;

trait Extendable
{
    /**
     * The list of custom methods.
     *
     * @var array<string, class-string<Method>>
     */
    protected static array $customMethods = [];

    /**
     * Register a custom Web3 method.
     *
     * @phpstan-param class-string<Method> $class
     */
    public static function extend(string $name, string $class): void
    {
        static::$customMethods[$name] = $class;
    }

    /**
     * Get the list of custom methods.
     *
     * @return array<string, class-string<Method>>
     */
    public static function getCustomMethods(): array
    {
        return static::$customMethods;
    }
}
