<?php

declare(strict_types=1);

namespace GroupLife\Core\Subscription;

use GroupLife\Core;

/**
 * FixedTime subscription allows one visit at exact day and time
 */
class FixedTime implements SubscriptionInterface, \JsonSerializable
{
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

    public function jsonSerialize(): \stdClass
    {
        $object = new \stdClass();
        $object->type = get_class($this);
        $object->startDay = $this->dateTime;
        $object->period = date_create('@0')->add($this->period)->getTimestamp();
        $object->activity = 'All activities';
        $object->visitor = $this->visitor;
        $object->status = 'Available';
        return $object;
    }
}
