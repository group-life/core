<?php

declare(strict_types=1);

namespace GroupLife\Core\tests\Subscription;

use GroupLife\Core\Subscription\Membership;
use GroupLife\Core\Visitor;
use PHPUnit\Framework\TestCase;

class MembershipTest extends TestCase
{
    public function testScheduleMembershipGetFunctions()
    {
        $purchase = new Membership(
            new \DateTimeImmutable('2021-01-01'),
            new \DateInterval('P1M'),
            new Visitor('Ivan', 'Pupkin')
        );
        $this->assertEquals(new \DateTimeImmutable('2021-01-01'), $purchase->getStartDay());
        $this->assertEquals(new \DateInterval('P1M'), $purchase->getPeriod());
    }
}
