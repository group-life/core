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

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param array $schedule
     */
    public function setSchedule(array $schedule): void
    {
        $this->schedule = $schedule;
    }

    public function subscribe(Visitor $visitor, Membership $subscription)
    {
        $activityVisits = [];
        $from = $subscription->getStartDay();
        $to = (clone $from)->add($subscription->getPeriod());
        foreach ($this->schedule as $day) {
            if ($day >= $from && $day <= $to) {
                $activityVisits[] = new Visit($day, $this->name, $visitor);
            }
        }
        return $activityVisits;
    }
}
