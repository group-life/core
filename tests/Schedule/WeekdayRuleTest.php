<?php

declare(strict_types=1);

namespace GroupLife\Core\tests\Schedule;

use GroupLife\Core\Schedule\WeekdayRule;
use PHPUnit\Framework\TestCase;

class WeekdayRuleTest extends TestCase
{

    public function testIncludedDays()
    {
        $dateFrom = new \DateTimeImmutable('2021-01-01');
        $oneMonth = new \DateInterval('P1M');
        $weekday = new WeekdayRule('Tuesday', '10:00');
        $this->assertEquals(
            [
            new \DateTimeImmutable('2021-01-05 10:00'),
            new \DateTimeImmutable('2021-01-12 10:00'),
            new \DateTimeImmutable('2021-01-19 10:00'),
            new \DateTimeImmutable('2021-01-26 10:00'),
            ],
            $weekday->includedDays($dateFrom, $oneMonth)
        );
    }

    public function testExcludedDays()
    {
        $dateFrom = new \DateTimeImmutable('2021-01-01');
        $oneMonth = new \DateInterval('P1M');
        $weekday = new WeekdayRule('Tuesday', '10:00');
        $this->assertEquals(
            [],
            $weekday->excludedDays($dateFrom, $oneMonth)
        );
    }
}
