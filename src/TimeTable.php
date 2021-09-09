<?php

declare(strict_types=1);

namespace GroupLife\Core;

class TimeTable
{
    private $activities;

    public function __construct(array $activities)
    {
        $this->activities = $activities;
    }

    /**
     * @return array
     */
    public function constructCalendar(\DateTime $startTime, \DateInterval $period): array
    {
        $calendar = [];
        foreach ($this->activities as $activity) {
            $calendar = array_merge($calendar, $activity->getCalendar(clone $startTime, $period));
        }
        usort($calendar, function ($a, $b) {
            return ($a->time <=> $b->time);
        });
        return $calendar;
    }
}
