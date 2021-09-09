<?php

declare(strict_types=1);

namespace GroupLife\Core;

use GroupLife\Core\Activity\Visit;
use GroupLife\Core\Schedule;
use GroupLife\Core\Subscription\Membership;

class Activity
{
    private $name;
    private $schedule;
    private $leader;

    public function __construct(string $name, Schedule $schedule)
    {
        $this->name = $name;
        $this->schedule = $schedule;
        $this->leader = 'Ivanov';
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function subscribe(Visitor $visitor, Membership $subscription): array
    {
        $activityVisits = [];
        foreach ($this->schedule->materialize($subscription->getStartDay(), $subscription->getPeriod()) as $day) {
                $activityVisits[] = new Visit($day, $this, $visitor);
        }
        return $activityVisits;
    }
    public function getCalendar(\DateTime $startTime, \DateInterval $period): array
    {
        $calendar = [];
        foreach ($this->schedule->materialize($startTime, $period) as $day) {
            $activity = new \stdClass();
            $activity->time = $day;
            $activity->activity = $this->name;
            $activity->leader = $this->leader;
            array_push($calendar, $activity);
        }
        return $calendar;
    }
}
