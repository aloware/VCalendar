<?php

namespace Davaxi\VCalendar\_;

use DateTimeZone;

/**
 * Trait TimeZone
 * @package Davaxi\VCalendar\_
 */
Trait TimeZone
{
    /**
     * @var string
     */
    protected $timeZone;

    /**
     * @param $timeZone string
     */
    public function setTimeZone($timeZone, $acceptOutdated = false)
    {
        $timezoneGroup = DateTimeZone::ALL;
        if ($acceptOutdated) {
            $timezoneGroup = DateTimeZone::ALL_WITH_BC;
        }
        if (!in_array($timeZone, timezone_identifiers_list($timezoneGroup))) {
            throw new \InvalidArgumentException('Invalid timeZone: ' . $timeZone);
        }
        $this->timeZone = $timeZone;
    }

    /**
     * @param array $result
     */
    protected function computeTimeZone(array &$result)
    {
        if ($this->eventAllDay) {
            return;
        }

        $result[] = 'BEGIN:VTIMEZONE';
        $result[] = sprintf('TZID:%s', $this->timeZone);
        $result[] = sprintf('X-LIC-LOCATION:%s', $this->timeZone);
        $result[] = 'END:VTIMEZONE';
    }
}