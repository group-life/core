<?php

declare(strict_types=1);

namespace GroupLife\Core\tests\Subscription;

use GroupLife\Core\Subscription\Membership;
use PHPUnit\Framework\TestCase;

class OneTimeTest extends TestCase
{
    public function testScheduleOneTimeTestGetFunctions()
    {
        $purchase = new Membership(new \DateTime('2021-01-01'), new \DateInterval('P1M'));
        $this->assertEquals(new \DateTime('2021-01-01'), $purchase->getStartDay());
        $this->assertEquals(new \DateInterval('P1M'), $purchase->getPeriod());
    }
}
