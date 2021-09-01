<?php

declare(strict_types=1);

namespace GroupLife\Core\Schedule;

class Weekday
{
    private \DateInterval $period;
    private string $weekday;
    private string $startTime;
    private \DateInterval $duration;

    public function __construct(string $weekday, string $startTime, \DateInterval $duration)
    {
        $this->weekday = $weekday;
        $this->startTime = $startTime;
        $this->duration = $duration;
        $this->period = new \DateInterval('P1W');
    }

    /**
     * @return \DateInterval
     */
    public function getPeriod(): \DateInterval
    {
        return $this->period;
    }
    /**
     * @return string
     */
    public function getWeekday(): string
    {
        return $this->weekday;
    }

    /**
     * @return string
     */
    public function getStartTime(): string
    {
        return $this->startTime;
    }

    /**
     * @return \DateInterval
     */
    public function getDuration(): \DateInterval
    {
        return $this->duration;
    }
}
