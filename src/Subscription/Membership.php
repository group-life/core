<?php

declare(strict_types=1);

namespace GroupLife\Core\Subscription;

use GroupLife\Core;

/**
 * Membership subscription allows to visit any activity
 */
class Membership implements SubscriptionInterface, \JsonSerializable
{
    private $startDay;
    private $period;
    private $visitor;

    /**
     * @param \DateTimeImmutable $startDay first day of a subscription
     * @param \DateInterval $period period of validity
     */
    public function __construct(\DateTimeImmutable $startDay, \DateInterval $period, Core\Visitor $visitor)
    {
        $this->startDay = $startDay;
        $this->period = $period;
        $this->visitor = $visitor;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getStartDay(): \DateTimeImmutable
    {
        return $this->startDay;
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
        $object->startDay = $this->startDay;
        $object->period = date_create('@0')->add($this->period)->getTimestamp();
        $object->activity = 'All activities';
        $object->visitor = $this->visitor;
        $object->status = 'Available';
        return $object;
    }
}
