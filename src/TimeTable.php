<?php

declare(strict_types=1);

namespace GroupLife\Core;

use GroupLife\Core\Activity\Visit;

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

    /**
     * @param Visit[] $visits
     * @param \DateTimeImmutable $startTime
     * @param \DateInterval $period
     * @return array
     */
    public function constructVisitsCalendar(array $visits, \DateTimeImmutable $startTime, \DateInterval $period): array
    {
        $calendar = [];
        foreach ($this->activities as $activity) {
            foreach ($activity->getCalendar($startTime, $period) as $day) {
                $activityData = getDataObject($activity);
                $dayData = getDataObject($day);
                $action = new \stdClass();
                $action->time = $day;
                $action->activity = $activityData->name;
                $action->leader = $activityData->leader->name . ' ' . $activityData->leader->surname;
                $calendar[] = $action;
                foreach ($visits as $visit) {
                    $visitData = getDataObject($visit);
                    if ($visitData->time == $dayData && $visitData->activity->name === $activityData->name) {
                        $action->visitor = $visitData->visitor->name . ' ' . $visitData->visitor->surname;
                        $action->status = $visitData->status;
                    }
                }
            }
        }

        usort($calendar, static function ($a, $b) {
            return ($a->time <=> $b->time);
        });
        return $calendar;
    }
}
