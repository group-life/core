<?php

declare(strict_types=1);

namespace GroupLife\Core;

use GroupLife\Core\Activity\Visit;
use GroupLife\Core\Subscription\Membership;

class Activity
{
    private $name;
    private $schedule;
    private $leader;

    public function __construct(string $name, Schedule $schedule, Leader $leader)
    {
        $this->name = $name;
        $this->schedule = $schedule;
        $this->leader = $leader;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getLeader(): Leader
    {
        return $this->leader;
    }

    public function subscribe(Visitor $visitor, Membership $subscription): array
    {
        $activityVisits = [];
        foreach ($this->schedule->materialize($subscription->getStartDay(), $subscription->getPeriod()) as $day) {
            $activityVisits[] = new Visit($day, $this, $visitor);
        }

        return $activityVisits;
    }

    public function getCalendar(\DateTimeImmutable $startTime, \DateInterval $period): array
    {
        return $this->schedule->materialize($startTime, $period);
    }
}
