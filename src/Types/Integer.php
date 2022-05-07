<?php

namespace Awuxtron\Web3\Types;

use Awuxtron\Web3\Utils\Hex;
use Brick\Math\BigInteger;
use Brick\Math\BigNumber;
use Brick\Math\Exception\MathException;
use InvalidArgumentException;
use OutOfRangeException;

class Integer extends EthereumType
{
    /**
     * The bits of the type.
     */
    protected int $bits = 256;

    /**
     * Create a new integer type object.
     */
    public function __construct(?int $bits = null, public bool $unsigned = false)
    {
        if ($bits !== null) {
            if (($bits < 8 || $bits > 256) || $bits % 8 !== 0) {
                throw new InvalidArgumentException('Invalid bits length.');
            }

            $this->bits = $bits;
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
            $num = BigNumber::of($value);

            if ($num->isLessThan($this->min()) || $num->isGreaterThan($this->max())) {
                return !$throw ? false : throw new OutOfRangeException('The given value is out of range. For ' . ($this->unsigned ? 'unsigned ' : '') . "{$this->bits} bits number, value must be in range: [{$this->min()} - {$this->max()}].");
            }

            return true;
        } catch (MathException) {
            return !$throw ? false : throw new InvalidArgumentException('The given value is not a valid number.');
        }
    }

    /**
     * Validate and return validated value.
     *
     * @param mixed $value
     *
     * @return BigInteger
     */
    public function validated(mixed $value): BigInteger
    {
        return BigInteger::of(parent::validated($value));
    }

    /**
     * Encodes value to its ABI representation.
     */
    public function encode(mixed $value, bool $validate = true, bool $pad = true): Hex
    {
        if ($validate) {
            $this->validate($value);
        }

        $value = BigInteger::of($value);
        $hex = Hex::fromInteger($value, $value->isNegative())->trim('0', Hex::HEX_TRIM_LEFT);

        if (!$pad) {
            return $hex;
        }

        return $hex->padLeft(32);
    }

    /**
     * Decodes ABI encoded string to its Ethereum type.
     */
    public function decode(mixed $value): BigInteger
    {
        return Hex::of($value)->toTwosComplement()->toInteger();
    }

    /**
     * Get the minimum value representable by the type.
     */
    public function min(): BigInteger
    {
        return $this->unsigned ? BigInteger::zero() : $this->max()->plus(1)->negated();
    }

    /**
     * Get the maximum value representable by the type.
     */
    public function max(): BigInteger
    {
        $max = BigInteger::of(2)->power($this->bits);

        if (!$this->unsigned) {
            $max = $max->dividedBy(2);
        }

        return $max->minus(1);
    }

    /**
     * Get the ethereum type name.
     */
    public function getName(): string
    {
        return ($this->unsigned ? 'u' : '') . 'int' . $this->bits;
    }
}
