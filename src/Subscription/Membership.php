<?php

declare(strict_types=1);

namespace GroupLife\Core\Subscription;

class AllActivitiesLimitedTime
{
    private $startDay;
    private $period;

    public function __construct(\DateTime $startDay, \DateInterval $period)
    {
        $this->startDay = $startDay;
        $this->period = $period;
    }
}
