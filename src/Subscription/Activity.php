<?php

declare(strict_types=1);

namespace GroupLife\Core\Subscription;

use GroupLife\Core;
use GroupLife\Core\Exception\SubscriptionIsForbidden;

/**
 * Activity subscription allows to visit a specific activity
 */
class Activity implements SubscriptionInterface, \JsonSerializable
{
    private $id;
    private $startDay;
    private $period;
    private $activity;
    private $visitor;

    /**
     * @param \DateTimeImmutable $startDay first day of a subscription
     * @param \DateInterval $period period of validity
     * @param Core\Activity $activity what activity is allowed
     */
    public function __construct(
        \DateTimeImmutable $startDay,
        \DateInterval $period,
        Core\Activity $activity,
        Core\Visitor $visitor
    ) {
        $this->startDay = $startDay;
        $this->period = $period;
        $this->activity = $activity;
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
     * @throws SubscriptionIsForbidden
     */
    public function assertValid(Core\Activity $activity): void
    {
        if ($this->activity->getName() !== $activity->getName()) {
            throw new SubscriptionIsForbidden('Your subscription is not valid for this activity');
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
        $object->activity = $this->activity;
        $object->visitor = $this->visitor;
        return $object;
    }
}
