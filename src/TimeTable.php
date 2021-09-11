<?php

declare(strict_types=1);

namespace GroupLife\Core;

class TimeTable
{
    private $activities;

    /**
     * @param Activity[] $activities
     */
    public function __construct(array $activities)
    {
        $this->activities = $activities;
    }

    /**
     * @param \DateTimeImmutable $startTime
     * @param \DateInterval $period
     * @return array
     */
    public function constructCalendar(\DateTimeImmutable $startTime, \DateInterval $period): array
    {
        $calendar = [];

        foreach ($this->activities as $activity) {
            foreach ($activity->getCalendar($startTime, $period) as $day) {
                $action = new \stdClass();
                $action->time = $day;
                $action->activity = $activity->getName();
                $action->leader = $activity->getLeader()->getFullName();
                $calendar[] = $action;
            }
        }

        usort($calendar, static function ($a, $b) {
            return ($a->time <=> $b->time);
        });

        return $calendar;
    }
}
