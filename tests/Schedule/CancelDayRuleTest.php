<?php

declare(strict_types=1);

namespace GroupLife\Core\tests\Schedule;

use GroupLife\Core\Schedule\CancelDayRule;
use PHPUnit\Framework\TestCase;

class CancelDayRuleTest extends TestCase
{

    public function testIncludedDays()
    {
        $dateFrom = new \DateTime('2021-01-01');
        $oneMonth = new \DateInterval('P1M');
        $cancelDays = new CancelDayRule('2021-01-02', '09:00');
        $this->assertEquals(
            [],
            $cancelDays->includedDays($dateFrom, $oneMonth)
        );
    }

    public function testExcludedDays()
    {
        $dateFrom = new \DateTime('2021-01-01');
        $oneMonth = new \DateInterval('P1M');
        $cancelDays = new CancelDayRule('2021-01-02', '09:00');
        $this->assertEquals(
            [
                new \DateTime('2021-01-02 09:00'),
            ],
            $cancelDays->excludedDays($dateFrom, $oneMonth)
        );
    }
}
