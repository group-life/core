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

    public function __construct(string $name, Schedule $schedule)
    {
        $this->name = $name;
        $this->schedule = $schedule;
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
}
