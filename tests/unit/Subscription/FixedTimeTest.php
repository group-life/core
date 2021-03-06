<?php

declare(strict_types=1);

namespace GroupLife\Core\tests\Subscription;

use GroupLife\Core\Subscription\FixedTime;
use GroupLife\Core\Visitor;
use PHPUnit\Framework\TestCase;

class FixedTimeTest extends TestCase
{
    /**
     * @throws \Exception
     */
    public function testScheduleFixedTimeGetFunctions()
    {
        $this->assertEquals(
            new \DateTimeImmutable('2021-01-01'),
            self::fixedTimeSubscription()->getStartDay()
        );
        $this->assertEquals(new \DateInterval('P1D'), self::fixedTimeSubscription()->getPeriod());
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
                    "type": "GroupLife\\Core\\Subscription\\FixedTime",
                    "startDay": {
                        "date": "2021-01-01 00:00:00.000000",
                        "timezone_type": 3,
                        "timezone": "Europe\/Berlin"
                    },
                    "period": "P0Y0M1DT0H0M0S",
                    "visitor": {
                        "id": null,
                        "name": "Sidor",
                        "surname": "Sidorov"
                    }
                }
            JSON,
            json_encode(self::fixedTimeSubscription())
        );
    }

    /**
     * @return FixedTime
     * @throws \Exception
     */
    private static function fixedTimeSubscription(): FixedTime
    {
        $visitor = new Visitor('Sidor', 'Sidorov');
        return new FixedTime(new \DateTimeImmutable('2021-01-01'), $visitor);
    }
}
