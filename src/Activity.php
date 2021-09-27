<?php

declare(strict_types=1);

namespace GroupLife\Core;

use GroupLife\Core\Activity\Visit;
use GroupLife\Core\Subscription\SubscriptionInterface;
use GroupLife\Core\Exception\SubscriptionIsForbidden;

class Activity implements \JsonSerializable
{
    private $id;
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

        $subscription->assertValid($this);
        foreach ($this->schedule->materialize($subscription->getStartDay(), $subscription->getPeriod()) as $day) {
            $activityVisits[] = new Visit($day, $this, $visitor);
        }
        return $activityVisits;
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

    /**
     * @param int $id
     */
    public function persists(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return \stdClass
     */
    public function jsonSerialize(): \stdClass
    {
        $data = new \stdClass();
        $data->id = $this->id;
        $data->name = $this->name;
        $data->leader = $this->leader;
        $data->schedule = $this->schedule;
        return $data;
    }
}
