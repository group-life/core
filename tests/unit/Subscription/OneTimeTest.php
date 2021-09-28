<?php

declare(strict_types=1);

namespace GroupLife\Core\tests\Subscription;

use GroupLife\Core\Subscription\OneTime;
use GroupLife\Core\Visitor;
use PHPUnit\Framework\TestCase;

class OneTimeTest extends TestCase
{
    /**
     * @throws \Exception
     */
    public function testScheduleOneTimeTestGetFunctions()
    {

        $this->assertEquals(
            new \DateTimeImmutable('2021-01-01', new \DateTimeZone('Europe/Berlin')),
            self::oneTimeSubscription()->getStartDay()
        );
        $this->assertEquals(new \DateInterval('P1M'), self::oneTimeSubscription()->getPeriod());
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
                    "type": "GroupLife\\Core\\Subscription\\OneTime",
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
            json_encode(self::oneTimeSubscription())
        );
    }

    /**
     * @return OneTime
     * @throws \Exception
     */
    private static function oneTimeSubscription(): OneTime
    {
        $visitor = new Visitor('Sidor', 'Sidorov');
        return new OneTime(
            new \DateTimeImmutable('2021-01-01', new \DateTimeZone('Europe/Berlin')),
            new \DateInterval('P1M'),
            $visitor
        );
    }
}
