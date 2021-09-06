<?php

namespace GroupLife\Core\tests\Subscription;

use GroupLife\Core\Subscription\AllActivitiesLimitedTime;
use PHPUnit\Framework\TestCase;

class AllActivitiesLimitedTimeTest extends TestCase
{
    public function someTest()
    {
        $purchase = new AllActivitiesLimitedTime(
            new \DateTime('2021-01-01'),
            new \DateInterval('P1M')
        );
        $this->assertIsObject($purchase);
    }
}
