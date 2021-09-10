<?php

namespace GroupLife\Core\Subscription;

interface SubscriptionInterface
{
    /**
     * @return \DateTime
     */
    public function getStartDay(): \DateTime;

    /**
     * @return \DateInterval
     */
    public function getPeriod(): \DateInterval;
}
