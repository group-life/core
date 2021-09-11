<?php

declare(strict_types=1);

namespace GroupLife\Core\tests\Schedule;

use Cassandra\Date;
use GroupLife\Core\Schedule\DayRule;
use PHPUnit\Framework\TestCase;

class DayRuleTest extends TestCase
{

    public function testIncludedDays()
    {
        $dateFrom = new \DateTimeImmutable('2021-01-01');
        $oneMonth = new \DateInterval('P1M');
        $day = new DayRule(new \DateTimeImmutable('2021-01-02 09:00'));
        $this->assertEquals(
            [
                new \DateTimeImmutable('2021-01-02 09:00'),
            ],
            $day->includedDays($dateFrom, $oneMonth)
        );
    }

    public function testExcludedDays()
    {
        $dateFrom = new \DateTimeImmutable('2021-01-01');
        $oneMonth = new \DateInterval('P1M');
        $day = new DayRule(new \DateTimeImmutable('2021-01-02 09:00'));
        $this->assertEquals(
            [],
            $day->excludedDays($dateFrom, $oneMonth)
        );
    }
}
