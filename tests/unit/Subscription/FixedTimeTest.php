<?php

declare(strict_types=1);

namespace GroupLife\Core\tests\Subscription;

use GroupLife\Core\Subscription;
use GroupLife\Core\Visitor;
use PHPUnit\Framework\TestCase;

class FixedTimeTest extends TestCase
{
    public function testScheduleFixedTimeGetFunctions()
    {
        $visitor = new Visitor('Sidor', 'Sidorov');
        $purchase = new Subscription\FixedTime(new \DateTimeImmutable('2021-01-01'), $visitor);
        $this->assertEquals(new \DateTimeImmutable('2021-01-01'), $purchase->getStartDay());
        $this->assertEquals(new \DateInterval('P1D'), $purchase->getPeriod());
    }
}
