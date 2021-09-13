<?php

declare(strict_types=1);

namespace GroupLife\Core\Subscription;

use GroupLife\Core;
use GroupLife\Core\Exception\SubscriptionIsForbidden;

/**
 * OneTime subscription allows one visit during period of its validity
 */
class OneTime implements SubscriptionInterface
{
    private $startDay;
    private $period;
    private $status = 'Available';

    /**
     * @param \DateTimeImmutable $startDay first day of a subscription
     * @param \DateInterval $period period of validity
     */
    public function __construct(\DateTimeImmutable $startDay, \DateInterval $period)
    {
        $this->startDay = $startDay;
        $this->period = $period;
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
        if ($this->status !== 'Available') {
            throw new SubscriptionIsForbidden('This subscription has already been used ');
        }
    }
}
