<?php

declare(strict_types=1);

namespace GroupLife\Core\Schedule;

class Weekday implements RuleInterface
{
    private $weekday;
    private $startTime;
    private $period;

    public function __construct(string $weekday, string $startTime)
    {
        $this->weekday = $weekday;
        $this->startTime = $startTime;
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
}
