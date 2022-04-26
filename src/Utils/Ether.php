<?php

namespace Awuxtron\Web3\Utils;

use Brick\Math\BigDecimal;
use Brick\Math\BigNumber;
use InvalidArgumentException;

class Ether
{
    /**
     * Complete ethereum unit map from ethjs-unit.
     */
    public const UNITS = [
        'noether' => '0',
        'wei' => '1',
        'kwei' => '1000',
        'Kwei' => '1000',
        'babbage' => '1000',
        'femtoether' => '1000',
        'mwei' => '1000000',
        'Mwei' => '1000000',
        'lovelace' => '1000000',
        'picoether' => '1000000',
        'gwei' => '1000000000',
        'Gwei' => '1000000000',
        'shannon' => '1000000000',
        'nanoether' => '1000000000',
        'nano' => '1000000000',
        'szabo' => '1000000000000',
        'microether' => '1000000000000',
        'micro' => '1000000000000',
        'finney' => '1000000000000000',
        'milliether' => '1000000000000000',
        'milli' => '1000000000000000',
        'ether' => '1000000000000000000',
        'kether' => '1000000000000000000000',
        'grand' => '1000000000000000000000',
        'mether' => '1000000000000000000000000',
        'gether' => '1000000000000000000000000000',
        'tether' => '1000000000000000000000000000000',
    ];

    /**
     * Convert number from Wei to unit.
     *
     * @param BigNumber|float|int|string $number
     * @param string                     $unit
     *
     * @return BigNumber
     */
    public static function fromWei(BigNumber|string|int|float $number, string $unit = 'ether'): BigNumber
    {
        $unitValue = self::getUnitValue($unit);

        if ($unitValue->isZero()) {
            return BigNumber::of(0);
        }

        return BigDecimal::of($number)->exactlyDividedBy($unitValue);
    }

    /**
     * Get value of the unit in Wei.
     *
     * @param string $unit
     *
     * @return BigNumber
     */
    public static function getUnitValue(string $unit = 'ether'): BigNumber
    {
        $unit = strtolower($unit);

        if (!array_key_exists($unit, self::UNITS)) {
            throw new InvalidArgumentException("The unit '{$unit}' does not exist.");
        }

        return BigNumber::of(self::UNITS[$unit]);
    }

    /**
     * Convert number to Wei by unit.
     *
     * @param BigNumber|float|int|string $number
     * @param string                     $unit
     *
     * @return BigNumber
     */
    public static function toWei(BigNumber|string|int|float $number, string $unit = 'ether'): BigNumber
    {
        return BigDecimal::of($number)->multipliedBy(self::getUnitValue($unit))->stripTrailingZeros();
    }

    /**
     * Get the unit name by value of unit map.
     *
     * @param BigNumber|float|int|string $value
     *
     * @return string
     */
    public static function getUnitByValue(BigNumber|string|int|float $value): string
    {
        $unit = collect(self::UNITS)->filter(function ($val) use ($value) {
            if ((string) $value === '0' && $val === 'noether') {
                return true;
            }

            if ((string) $value === '1' && $val === 'wei') {
                return true;
            }

            return (string) BigDecimal::of($value) === $val;
        })->keys()->first();

        if (empty($unit)) {
            throw new InvalidArgumentException("Could not find unit by the value '{$value}'");
        }

        return $unit;
    }
}
