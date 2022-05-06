<?php

namespace Awuxtron\Web3\Types;

use Awuxtron\Web3\Utils\Hex;
use Brick\Math\BigDecimal;
use Brick\Math\Exception\MathException;
use InvalidArgumentException;

class Fixed extends EthereumType
{
    /**
     * The bits of the type.
     */
    protected int $bits = 128;

    /**
     * The decimals of the type.
     */
    protected int $decimals = 18;

    /**
     * Create a new integer type object.
     */
    public function __construct(?int $bits = null, public bool $unsigned = false, ?int $decimals = null)
    {
        if ($bits !== null) {
            if (($bits < 8 || $bits > 256) || $bits % 8 !== 0) {
                throw new InvalidArgumentException('Invalid bits length.');
            }

            $this->bits = $bits;
        }

        if ($decimals !== null) {
            if ($decimals <= 0 || $decimals > 80) {
                throw new InvalidArgumentException('Decimal points must be in range: 1-80.');
            }

            $this->decimals = $decimals;
        }
    }

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
        try {
            $num = BigDecimal::of($value);

            if ($num->getScale() !== $this->decimals) {
                throw new InvalidArgumentException("The value '{$value}' must have exactly {$this->decimals} numbers in decimal part.");
            }

            return (new Integer($this->bits, $this->unsigned))->validate($value, $throw);
        } catch (MathException) {
            return !$throw ? false : throw new InvalidArgumentException('The given value is not a valid number.');
        }
    }

    /**
     * Validate and return validated value.
     *
     * @param mixed $value
     *
     * @return BigDecimal
     */
    public function validated(mixed $value): BigDecimal
    {
        return BigDecimal::of(parent::validated($value));
    }

    /**
     * Encodes value to its ABI representation.
     */
    public function encode(mixed $value, bool $validate = true, bool $pad = true): Hex
    {
        if ($validate) {
            $this->validate($value);
        }

        $value = BigDecimal::of($value);
        $hex = Hex::fromInteger($value->getUnscaledValue(), $value->isNegative());

        if (!$pad) {
            return $hex;
        }

        return $hex->padLeft(32);
    }

    /**
     * Decodes ABI encoded string to its Ethereum type.
     */
    public function decode(string|Hex $value): BigDecimal
    {
        return Hex::of($value)->toTwosComplement()->toInteger()->toBigDecimal()->toScale($this->decimals);
    }

    /**
     * Get the ethereum type name.
     */
    public function getName(): string
    {
        return ($this->unsigned ? 'u' : '') . 'fixed' . $this->bits . 'x' . $this->decimals;
    }
}
