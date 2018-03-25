<?php

namespace Xoptov\TradingCore;

use SplFixedArray;

class Calculator
{
    /**
     * Method for calculating Increasing Arithmetic Progression.
     *
     * @param float $a Base number.
     * @param int   $n Count of members.
     * @param float $d Number of increment.
     * @return float
     */
    public static function ap($a, $n, $d)
    {
        return floatval($a + $d * ($n - 1));
    }

    /**
     * Method for calculating Geometric Progression.
     *
     * @param float $a Base number.
     * @param int   $n Count of members.
     * @param float $d Number of calculation.
     * @return float
     */
    public static function gp($a, $n, $d)
    {
        return floatval($a * pow($d, $n - 1));
    }

    /**
     * Method for calculating Compound Interest.
     *
     * @param float $a Start number.
     * @param int   $n Count of calculating period.
     * @param float $p Percent number.
     * @return float
     */
    public static function ci($a, $n, $p)
    {
        return floatval($a * pow((1 + $p / 100), $n));
    }

    /**
     * Method for generating Arithmetic Sequence of Number.
     *
     * @param float    $a    Start number.
     * @param int      $n    Count of members.
     * @param float    $d    Number for calculation sequence.
     * @param callable $func Function for sequence generation.
     * @return SplFixedArray
     */
    public static function ans($a, $n, $d, callable $func)
    {
        $seq = new SplFixedArray($n);

        for ($i = 1; $i <= $n; $i++) {
            $seq->offsetSet($i - 1, call_user_func($func, $a, $i, $d));
        }

        return $seq;
    }

    /**
     * Method for generating Compound Interests Sequence of Number.
     * @param float $a Base number.
     * @param int   $n Calculation period.
     * @param float $p Percent number.
     * @return SplFixedArray
     */
    public static function cins($a, $n, $p)
    {
        $seq = new SplFixedArray($n);

        for ($i = 0; $i < $n; $i++) {
            $seq->offsetSet($i, static::ci($a, $i, $p));
        }

        return $seq;
    }
}