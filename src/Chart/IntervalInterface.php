<?php

namespace Xoptov\TradingCore\Chart;

interface IntervalInterface
{
    /**
     * @return mixed
     */
    public function getMin();

    /**
     * @return mixed
     */
    public function get3Min();

    /**
     * @return mixed
     */
    public function get5Min();

    /**
     * @return mixed
     */
    public function get15Min();

    /**
     * @return mixed
     */
    public function getHalfHour();

    /**
     * @return mixed
     */
    public function getHour();

    /**
     * @return mixed
     */
    public function get2Hour();

    /**
     * @return mixed
     */
    public function get4Hour();

    /**
     * @return mixed
     */
    public function get6Hour();

    /**
     * @return mixed
     */
    public function get8Hour();

    /**
     * @return mixed
     */
    public function getHalfDay();

    /**
     * @return mixed
     */
    public function getDay();

    /**
     * @return mixed
     */
    public function get3Day();

    /**
     * @return mixed
     */
    public function getWeek();

    /**
     * @return mixed
     */
    public function getMonth();
}