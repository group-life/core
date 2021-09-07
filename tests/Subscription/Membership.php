<?php

namespace GroupLife\Core\tests\Subscription;

use GroupLife\Core\Subscription\Membership;
use PHPUnit\Framework\TestCase;

class MembershipTest extends TestCase
{
    public function someTest()
    {
        $purchase = new Membership(
            new \DateTime('2021-01-01'),
            new \DateInterval('P1M')
        );
        $this->assertIsObject($purchase);
    }
}
