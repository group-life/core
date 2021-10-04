<?php

declare(strict_types=1);

namespace GroupLife\Core\tests\Activity;

use GroupLife\Core\Activity;
use GroupLife\Core\DataMapper\SubscriptionMapper;
use GroupLife\Core\Leader;
use GroupLife\Core\Schedule;
use GroupLife\Core\Subscription\Membership;
use GroupLife\Core\Visitor;
use PHPUnit\Framework\TestCase;
use GroupLife\Core\Activity\Visit;

class VisitTest extends TestCase
{
    public function testCreateNewObject()
    {
        $this->assertIsObject(self::visit());
    }

    public function testJsonSerialize()
    {
        self::assertJsonStringEqualsJsonString(<<<'JSON'
    {
    "id": null,
    "time": {
        "date": "2021-01-01 10:00:00.000000",
        "timezone_type": 3,
        "timezone": "Europe\/Berlin"
    },
    "status": "planned",
    "subscription": {
        "id": null,
        "period": "P0Y1M0DT0H0M0S",
        "startDay": {
            "date": "2021-01-01 00:00:00.000000",
            "timezone": "Europe/Berlin",
            "timezone_type": 3
        },
        "type": "GroupLife\\Core\\Subscription\\Membership",
        "visitor": {
            "id": null,
            "name": "Stapan",
            "surname": "Petrov"
        }
    },
    "activity": {
        "id": null,
        "name": "Swimming",
        "schedule": {
            "id": null,
            "rules": [
                {
                    "type": "GroupLife\\Core\\Schedule\\DayRule",
"data": "{\"dateTime\":{\"date\":\"2021-01-01 10:00:00.000000\",\"timezone_type\":3,\"timezone\":\"Europe\\\/Berlin\"}}"
                }
            ]
        },
        "leader": {
            "id": null,
            "name": "Ivan",
            "surname": "Ivanov"
        }
    },
    "visitor": {
        "id": null,
        "name": "Ivan",
        "surname": "Pupkin"
    }
}
JSON, json_encode(self::visit()));
    }

    public static function visit(): Visit
    {
        $leader = new Leader('Ivan', 'Ivanov');
        $schedule = new Schedule([
            new Schedule\DayRule(new \DateTimeImmutable('2021-01-01 10:00'))
        ]);
        $visitor = new Visitor('Stapan', 'Petrov');
        $subscription = new Membership(new \DateTimeImmutable('2021-01-01'), new \DateInterval('P1M'), $visitor);
        return new Visit(
            new \DateTimeImmutable('2021-01-01 10:00'),
            new Activity('Swimming', $schedule, $leader),
            new Visitor('Ivan', 'Pupkin'),
            $subscription
        );
    }
}
