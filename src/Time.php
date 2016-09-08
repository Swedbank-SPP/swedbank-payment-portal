<?php

namespace SwedbankPaymentPortal;

/**
 * Class for handling time logic.
 */
class Time
{
    /**
     * @var int Current timestamp.
     */
    private static $time;

    /**
     * Return current time based on this class.
     *
     * @return int
     */
    public static function getCurrentTime()
    {
        return self::$time !== null ? self::$time : time();
    }

    /**
     * Set current time (USE WITH CAUTION).
     *
     * @param int $time
     */
    public static function __setCurrentTime($time)
    {
        self::$time = $time;
    }
}
