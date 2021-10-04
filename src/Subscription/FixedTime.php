<?php

declare(strict_types=1);

namespace GroupLife\Core\Subscription;

use GroupLife\Core;

/**
 * FixedTime subscription allows one visit at exact day and time
 */
class FixedTime implements SubscriptionInterface, \JsonSerializable
{
    private $id;
    private $dateTime;
    private $period;
    private $visitor;

    /**
     * @param \DateTimeImmutable $dateTime at what day and time a subscription is valid
     */
    public function __construct(\DateTimeImmutable $dateTime, Core\Visitor $visitor)
    {
        $this->dateTime = $dateTime;
        $this->period = new \DateInterval('P1D');
        $this->visitor = $visitor;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getStartDay(): \DateTimeImmutable
    {
        return $this->dateTime;
    }

    /**
     * @return \DateInterval
     */
    public function getPeriod(): \DateInterval
    {
        return $this->period;
    }

    /**
     * @param Core\Activity $activity
     */
    public function assertValid(Core\Activity $activity): void
    {
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
        $object = new \stdClass();
        $object->id = $this->id;
        $object->type = get_class($this);
        $object->startDay = $this->dateTime;
        $object->period = $this->period->format('P%yY%mM%dDT%hH%iM%sS');
        $object->visitor = $this->visitor;
        return $object;
    }
}
