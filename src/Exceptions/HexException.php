<?php

namespace Awuxtron\Web3\Exceptions;

use Exception;

class HexException extends Exception
{
    /**
     * The exception value.
     */
    protected mixed $value;

    /**
     * Set the exception value.
     */
    public function setValue(mixed $value): static
    {
        $this->value = $value;

        return $this;
    }
}
