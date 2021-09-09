<?php

declare(strict_types=1);

namespace GroupLife\Core\tests\Subscription;

use GroupLife\Core\Subscription;
use PHPUnit\Framework\TestCase;

class FixedTimeTest extends TestCase
{
    public function testScheduleFixedTimeGetFunctions()
    {
        $purchase = new Subscription\FixedTime(new \DateTime('2021-01-01'));
        $this->assertEquals(new \DateTime('2021-01-01'), $purchase->getStartDay());
        $this->assertEquals(new \DateInterval('P1D'), $purchase->getPeriod());
    }
}
