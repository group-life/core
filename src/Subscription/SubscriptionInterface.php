<?php

namespace GroupLife\Core\Subscription;

use GroupLife\Core\Exception\SubscriptionIsForbidden;
use GroupLife\Core;

interface SubscriptionInterface
{
    /**
     * @return \DateTimeImmutable
     */
    public function getStartDay(): \DateTimeImmutable;

    /**
     * @return \DateInterval
     */
    public function getPeriod(): \DateInterval;

    /**
     * @param Core\Activity $activity
     * @throws SubscriptionIsForbidden
     */
    public function isValid(Core\Activity $activity): void;
}
