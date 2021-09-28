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
        $this->assertEquals(new \DateTimeImmutable('2021-01-01'), self::membershipSubscription()->getStartDay());
        $this->assertEquals(new \DateInterval('P1M'), self::membershipSubscription()->getPeriod());
    }

    public function testJsonSerialize()
    {
        self::assertJsonStringEqualsJsonString(
            <<<'JSON'
                {
                    "id": null,
                    "type": "GroupLife\\Core\\Subscription\\Membership",
                    "startDay": {
                        "date": "2021-01-01 00:00:00.000000",
                        "timezone_type": 3,
                        "timezone": "Europe\/Berlin"
                    },
                    "period": 2678400,
                    "activity": null,
                    "visitor": {
                        "id": null,
                        "name": "Sidor",
                        "surname": "Sidorov"
                    },
                    "status": "Available"
                }
            JSON,
            json_encode(self::membershipSubscription())
        );
    }

    private static function membershipSubscription(): Membership
    {
        $visitor = new Visitor('Sidor', 'Sidorov');
        return new Membership(new \DateTimeImmutable('2021-01-01'), new \DateInterval('P1M'), $visitor);
    }
}
