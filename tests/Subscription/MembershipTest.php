<?php

namespace GroupLife\Core\tests\Subscription;

use GroupLife\Core\Subscription\Membership;
use PHPUnit\Framework\TestCase;

class MembershipTest extends TestCase
{
    public function testConstructor()
    {
        new Membership(
            new \DateTime('2021-01-01'),
            new \DateInterval('P1M')
        );
    }
}
