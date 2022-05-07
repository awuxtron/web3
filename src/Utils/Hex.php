<?php

namespace Awuxtron\Web3\Utils;

use Awuxtron\Web3\Exceptions\HexException;
use Brick\Math\BigInteger;
use Brick\Math\BigNumber;
use InvalidArgumentException;
use JsonSerializable;

class Hex implements JsonSerializable
{
    public const HEX_TRIM_LEFT = 0;
    public const HEX_TRIM_RIGHT = 1;

    /**
     * Create a new instance of the class.
     *
     * @param string $value            the underlying hex string value without sign and prefix
     * @param bool   $isNegative
     * @param bool   $isTwosComplement
     */
    final protected function __construct(protected string $value, public bool $isNegative, public bool $isTwosComplement = false)
    {
    }

    /**
     * Get the raw string value.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->value();
    }

    /**
     * Get a new hex object from the given hex string.
     */
    public static function of(self|string $hex, ?bool $isNegative = null, bool $isTwosComplement = false): self
    {
        if ($hex instanceof self) {
            return $hex;
        }

        if (!static::isValid($hex)) {
            throw new InvalidArgumentException('The given value is not a valid hex string.');
        }

        if ($isNegative === null) {
            if ($isTwosComplement) {
                throw new InvalidArgumentException('You must to specified $isNegative when $isTwosComplement is true');
            }

            $isNegative = static::isNegative($hex);
        }

        return new static(static::stripPrefix($hex, true), $isNegative, $isTwosComplement);
    }

    /**
     * Convert a value of type boolean into the hex object.
     */
    public static function fromBoolean(bool $value): static
    {
        return new static($value ? '1' : '0', false);
    }

    /**
     * Convert an integer or big number object into hexadecimal object.
     */
    public static function fromInteger(BigNumber|string|int|float $number, bool $twosComplement = false): static
    {
        if (str_contains((string) $number, '.')) {
            throw new InvalidArgumentException("Float number '{$number}' is not supported. If you try to convert a large integer, pass it as string.");
        }

        $number = BigInteger::of($number);

        return new static(
            $twosComplement ? bin2hex($number->toBytes()) : $number->abs()->toBase(16),
            $number->isNegative(),
            $twosComplement
        );
    }

    /**
     * Convert a string into the hex object.
     *
     * @throws HexException
     */
    public static function fromString(string $value): static
    {
        $hex = unpack('H*', trim($value));

        if ($hex == false) {
            throw (new HexException('Unable to convert the given string into the hex object.'))->setValue($value);
        }

        return new static(implode('', $hex), false);
    }

    /**
     * Concat multiple hex into one.
     */
    public static function concat(self|string ...$values): static
    {
        $isNegative = static::isNegative($values[0]);

        $hexes = array_map(static function ($hex) use ($isNegative) {
            $instance = static::of($hex);

            if ($isNegative !== $instance->isNegative) {
                throw new InvalidArgumentException('All hex strings must same sign.');
            }

            return $instance->value;
        }, $values);

        return new static(implode('', $hexes), $isNegative);
    }

    /**
     * Checks if the hex string is negative.
     */
    public static function isNegative(self|string $hex): bool
    {
        return ($hex instanceof self && $hex->isNegative) || str_starts_with($hex, '-');
    }

    /**
     * Checks if given value is a valid hex string.
     */
    public static function isValid(self|string $hex, bool $checkPrefix = false, bool $checkLength = false): bool
    {
        if ($hex instanceof self) {
            return true;
        }

        if ($checkLength && strlen($hex) % 2 != 0) {
            return false;
        }

        $pattern = '/^' . ($checkPrefix ? '(-)?0x' : '(-0x|0x|-)?') . '[[:xdigit:]]*$/i';

        return $hex !== '' && preg_match($pattern, $hex) == 1;
    }

    /**
     * Strip 0x prefix from start of hex string.
     */
    public static function stripPrefix(self|string $hex, bool $stripSign = false): string
    {
        if ($hex instanceof self) {
            return $hex->value;
        }

        $sign = preg_replace('/' . ($stripSign ? '(-)?' : '') . '(0x)?/i', '', substr($hex, 0, 3));

        return $sign . substr($hex, 3);
    }

    /**
     * Append the given hexes to the current hex string.
     */
    public function append(self|string ...$values): static
    {
        return $this->newInstance(static::concat($this->value(), ...$values)->value);
    }

    /**
     * Checks if the given hex string is equal with current hex string.
     */
    public function isEqual(self|string $hex): bool
    {
        return $this->lower()->prefixed() === static::of($hex)->lower()->prefixed();
    }

    /**
     * Checks if the hex is zero.
     */
    public function isZero(): bool
    {
        return (bool) preg_match('/^0+$/', $this->value);
    }

    /**
     * Returns the length (in bytes) of the hex string.
     */
    public function length(): int
    {
        return count(str_split($this->value, 2));
    }

    /**
     * Converts the current hex string to lowercase.
     */
    public function lower(): static
    {
        return $this->newInstance(strtolower($this->value));
    }

    /**
     * Wrap of str_pad function with length in bytes.
     */
    public function pad(int $length, ?string $pad = '0', int $type = STR_PAD_LEFT): static
    {
        if ($pad === null && $type === STR_PAD_LEFT) {
            $pad = $this->isTwosComplement && $this->isNegative ? 'ff' : '00';
        }

        return $this->newInstance(str_pad($this->value, $length * 2, (string) $pad, $type));
    }

    /**
     * Pad the left side of the hex string with another.
     *
     * @param int $length the length of final hex string (in bytes)
     */
    public function padLeft(int $length, string $pad = null): static
    {
        return $this->pad($length, $pad);
    }

    /**
     * Pad the right side of the hex string with another.
     *
     * @param int $length the length of final hex string (in bytes)
     */
    public function padRight(int $length, string $pad = '0'): static
    {
        return $this->pad($length, $pad, STR_PAD_RIGHT);
    }

    /**
     * Call the given callback and return a new hex object.
     */
    public function pipe(callable $callback): static
    {
        return $this->newInstance($callback($this));
    }

    /**
     * Get the underlying hex string value includes sign and prefix.
     */
    public function prefixed(): string
    {
        return $this->getSign() . '0x' . $this->value;
    }

    /**
     * Prepend the given hexes to the current hex string.
     */
    public function prepend(self|string ...$values): static
    {
        $values[] = $this->value();

        return $this->newInstance(static::concat(...$values)->value);
    }

    /**
     * Returns part of the hex string specified by the start (in bytes) and length (in bytes) parameters.
     */
    public function slice(BigNumber|int $start, BigNumber|int|null $length = null): static
    {
        $start = BigInteger::of($start)->toInt();

        if ($length !== null) {
            $length = BigInteger::of($length)->multipliedBy(2)->toInt();
        }

        return $this->newInstance(substr($this->value, $start * 2, $length));
    }

    /**
     * Split the hex object by length (in bytes).
     *
     * @return static[]
     */
    public function split(int $length): array
    {
        if ($length < 1) {
            throw new InvalidArgumentException('$length must be greater than 0.');
        }

        return array_map(fn ($part) => $this->newInstance($part), str_split($this->value, $length * 2));
    }

    /**
     * Remove 00 paddings from either side of the hex string.
     */
    public function stripZeros(): static
    {
        $pattern = '/^(?:00)*/';

        $stripped = strrev((string) preg_replace($pattern, '', $this->value));
        $stripped = strrev((string) preg_replace($pattern, '', $stripped));

        return new static($stripped != '' ? $stripped : '0', $this->isNegative, $this->isTwosComplement);
    }

    /**
     * Convert the current hex object to boolean.
     */
    public function toBoolean(): bool
    {
        return !$this->isZero();
    }

    /**
     * Convert the current hex object to a big number object.
     */
    public function toInteger(): BigInteger
    {
        if ($this->isTwosComplement) {
            return BigInteger::fromBytes((string) hex2bin($this->toEvenLength()));
        }

        return BigInteger::fromBase($this->value(), 16);
    }

    /**
     * Convert the current hex object to a decoded string.
     *
     * @throws HexException
     */
    public function toString(): string
    {
        if ($this->isNegative) {
            throw new HexException('Unable to decode negative hex to string.');
        }

        return trim(pack('H*', $this->value));
    }

    /**
     * Convert the current hex object to hex signed two's complement.
     */
    public function toTwosComplement(): static
    {
        if ($this->isTwosComplement) {
            return $this;
        }

        $number = BigInteger::fromBytes((string) hex2bin($this->toEvenLength()));

        return static::fromInteger($number, true);
    }

    /**
     * Converts the current hex string to even length.
     */
    public function toEvenLength(): static
    {
        return $this->newInstance((strlen($this->value) % 2 != 0 ? '0' : '') . $this->value);
    }

    /**
     * Trim any characters from hex string.
     *
     * @param string   $characters
     * @param null|int $position
     *
     * @return static
     */
    public function trim(string $characters, ?int $position = null): static
    {
        $using = match ($position) {
            self::HEX_TRIM_LEFT => 'ltrim',
            self::HEX_TRIM_RIGHT => 'rtrim',
            default => 'trim'
        };

        return $this->newInstance($using($this->value, $characters));
    }

    /**
     * Get the underlying hex string value with sign and without 0x prefix.
     */
    public function value(): string
    {
        return $this->getSign() . $this->value;
    }

    /**
     * Convert the object to a string when JSON encoded.
     */
    public function jsonSerialize(): string
    {
        return $this->__toString();
    }

    /**
     * Returns the new instance of the hex object.
     */
    protected function newInstance(string $value): static
    {
        return new static($value, $this->isNegative, $this->isTwosComplement);
    }

    /**
     * Get the sign of current hex string.
     */
    protected function getSign(): string
    {
        return $this->isNegative && !$this->isTwosComplement ? '-' : '';
    }
}
