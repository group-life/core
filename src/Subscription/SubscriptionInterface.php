<?php

namespace GroupLife\Core\Subscription;

use GroupLife\Core\Activity;

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

    /**
     * @return Activity|null
     */
    public function getActivity(): ?Activity;

    /**
     * @return \DateTime|null
     */
    public function getVisitDay(): ?\DateTime;

    /**
     * @return int
     */
    public function getVisitsNumber(): int;
}
