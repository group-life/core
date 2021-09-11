<?php

declare(strict_types=1);

namespace GroupLife\Core\tests\Subscription;

use GroupLife\Core\Subscription\Membership;
use PHPUnit\Framework\TestCase;

class MembershipTest extends TestCase
{
    public function testScheduleMembershipGetFunctions()
    {
        $purchase = new Membership(new \DateTimeImmutable('2021-01-01'), new \DateInterval('P1M'));
        $this->assertEquals(new \DateTimeImmutable('2021-01-01'), $purchase->getStartDay());
        $this->assertEquals(new \DateInterval('P1M'), $purchase->getPeriod());
    }
}
