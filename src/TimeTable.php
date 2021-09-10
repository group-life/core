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
            foreach ($activity->getCalendar(clone $startTime, $period) as $day) {
                $action = new \stdClass();
                $action->time = $day;
                $action->activity = $activity->getName();
                $action->leader = $activity->getLeader()->getFullName();
                array_push($calendar, $action);
            }
        }
        usort($calendar, function ($a, $b) {
            return ($a->time <=> $b->time);
        });
        return $calendar;
    }
}
