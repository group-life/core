<?php

namespace GroupLife\Core\Subscription;

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
}
