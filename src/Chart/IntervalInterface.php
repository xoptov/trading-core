<?php

namespace Xoptov\TradingCore\Chart;

interface IntervalInterface
{
    /**
     * @return mixed
     */
    public static function getMin();

    /**
     * @return mixed
     */
    public static function get3Min();

    /**
     * @return mixed
     */
    public static function get5Min();

    /**
     * @return mixed
     */
    public static function get15Min();

    /**
     * @return mixed
     */
    public static function getHalfHour();

    /**
     * @return mixed
     */
    public static function getHour();

    /**
     * @return mixed
     */
    public static function get2Hour();

    /**
     * @return mixed
     */
    public static function get4Hour();

    /**
     * @return mixed
     */
    public static function get6Hour();

    /**
     * @return mixed
     */
    public static function get8Hour();

    /**
     * @return mixed
     */
    public static function getHalfDay();

    /**
     * @return mixed
     */
    public static function getDay();

    /**
     * @return mixed
     */
    public static function get3Day();

    /**
     * @return mixed
     */
    public static function getWeek();

    /**
     * @return mixed
     */
    public static function getMonth();
}