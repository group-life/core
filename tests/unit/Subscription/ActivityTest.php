<?php

declare(strict_types=1);

namespace GroupLife\Core\tests\Subscription;

use GroupLife\Core;
use GroupLife\Core\Leader;
use GroupLife\Core\Subscription;
use PHPUnit\Framework\TestCase;

class ActivityTest extends TestCase
{
    /**
     * @throws \Exception
     */
    public function testScheduleActivityGetFunctions()
    {
        $this->assertEquals(
            new \DateTimeImmutable('2021-01-01'),
            self::activitySubscription()->getStartDay()
        );
        $this->assertEquals(new \DateInterval('P1M'), self::activitySubscription()->getPeriod());
    }

    /**
     * @throws \Exception
     */
    public function testJsonSerialize()
    {
        self::assertJsonStringEqualsJsonString(
            <<<'JSON'
                {
                    "id": null,
                    "type": "GroupLife\\Core\\Subscription\\Activity",
                    "startDay": {
                        "date": "2021-01-01 00:00:00.000000",
                        "timezone_type": 3,
                        "timezone": "Europe\/Berlin"
                    },
                    "period": 2678400,
                    "activity": {
                        "id": null,
                        "name": "Chess",
                        "schedule": {
                            "id": null,
                            "rules": [
                                {
                                    "type": "GroupLife\\Core\\Schedule\\WeekdayRule",
                                    "data": "{\"weekday\":\"Sunday\",\"startTime\":\"10:00\"}"
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
                        "name": "Sidor",
                        "surname": "Sidorov"
                    }
                }
    JSON,
            json_encode(self::activitySubscription(), JSON_PRETTY_PRINT)
        );
    }

    /**
     * @return Subscription\Activity
     * @throws \Exception
     */
    private static function activitySubscription(): Subscription\Activity
    {
        $leader = new Leader('Ivan', 'Ivanov');
        $visitor = new Core\Visitor('Sidor', 'Sidorov');
        $schedule = new Core\Schedule([new Core\Schedule\WeekdayRule('Sunday', '10:00')]);
        $activity = new Core\Activity('Chess', $schedule, $leader);
        return new Subscription\Activity(
            new \DateTimeImmutable('2021-01-01'),
            new \DateInterval('P1M'),
            $activity,
            $visitor
        );
    }
}
