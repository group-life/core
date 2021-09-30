<?php

declare(strict_types=1);

namespace GroupLife\Core\Subscription;

use GroupLife\Core;
use GroupLife\Core\Exception\SubscriptionIsForbidden;

/**
 * OneTime subscription allows one visit during period of its validity
 */
class OneTime implements SubscriptionInterface, \JsonSerializable
{
    private $id;
    private $startDay;
    private $period;
    private $visitor;
    private $status;

    /**
     * @param \DateTimeImmutable $startDay first day of a subscription
     * @param \DateInterval $period period of validity
     */
    public function __construct(
        \DateTimeImmutable $startDay,
        \DateInterval $period,
        Core\Visitor $visitor,
        bool $status = true
    ) {
        $this->startDay = $startDay;
        $this->period = $period;
        $this->visitor = $visitor;
        $this->status = $status;
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
     * @throws SubscriptionIsForbidden
     */
    public function assertValid(Core\Activity $activity): void
    {
        if ($this->status) {
            throw new SubscriptionIsForbidden('This subscription has already been used ');
        }
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
        $object->startDay = $this->startDay;
        $object->period = date_create('@0')->add($this->period)->getTimestamp();
        $object->visitor = $this->visitor;
        $object->status = $this->status;
        return $object;
    }
}
