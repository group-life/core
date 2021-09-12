<?php

declare(strict_types=1);

namespace GroupLife\Core;

use GroupLife\Core\Activity\Visit;
use GroupLife\Core\Subscription\SubscriptionInterface;
use GroupLife\Core\Exception\SubscriptionIsForbidden;

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

    /**
     * @param Visitor $visitor
     * @param SubscriptionInterface $subscription
     * @return Visit[]
     */
    public function subscribe(Visitor $visitor, SubscriptionInterface $subscription): array
    {
        $activityVisits = [];
        try {
            $subscription->assertValid($this);
            foreach ($this->schedule->materialize($subscription->getStartDay(), $subscription->getPeriod()) as $day) {
                $activityVisits[] = new Visit($day, $this, $visitor);
            }
        } catch (SubscriptionIsForbidden $exception) {
            throw $exception;
        } finally {
            return $activityVisits;
        }
    }

    /**
     * @param \DateTimeImmutable $startTime
     * @param \DateInterval $period
     * @return array
     */
    public function getCalendar(\DateTimeImmutable $startTime, \DateInterval $period): array
    {
        return $this->schedule->materialize($startTime, $period);
    }
}
