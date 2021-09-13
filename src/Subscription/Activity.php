<?php

declare(strict_types=1);

namespace GroupLife\Core\Subscription;

use GroupLife\Core;
use GroupLife\Core\Exception\SubscriptionIsForbidden;

/**
 * Activity subscription allows to visit a specific activity
 */
class Activity implements SubscriptionInterface
{
    private $startDay;
    private $period;
    private $activity;

    /**
     * @param \DateTimeImmutable $startDay first day of a subscription
     * @param \DateInterval $period period of validity
     * @param Core\Activity $activity what activity is allowed
     */
    public function __construct(
        \DateTimeImmutable $startDay,
        \DateInterval $period,
        Core\Activity $activity
    ) {
        $this->startDay = $startDay;
        $this->period = $period;
        $this->activity = $activity;
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
}
