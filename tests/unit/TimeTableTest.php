<?php

declare(strict_types=1);

namespace GroupLife\Core\tests;

use GroupLife\Core\Activity;
use GroupLife\Core\Leader;
use GroupLife\Core\Schedule;
use GroupLife\Core\Schedule\WeekdayRule;
use GroupLife\Core\Subscription\Membership;
use GroupLife\Core\TimeTable;
use GroupLife\Core\Visitor;
use PHPUnit\Framework\TestCase;

class TimeTableTest extends TestCase
{
    protected $activity1;
    protected $activity2;
    protected $activity3;

    protected function setUp(): void
    {
        $leader = new Leader('Ivan', 'Ivanov');
        $schedule1 = new Schedule([new WeekdayRule('Monday', '09:00')]);
        $this->activity1 = new Activity('Skiing', $schedule1, $leader);
        $schedule2 = new Schedule([new WeekdayRule('Wednesday', '10:00')]);
        $this->activity2 = new Activity('Chess', $schedule2, $leader);
        $schedule3 = new Schedule([new WeekdayRule('Thursday', '11:00')]);
        $this->activity3 = new Activity('Swimming', $schedule3, $leader);
    }

    public function testConstructCalendar()
    {
        $calendar = new TimeTable([$this->activity1, $this->activity2, $this->activity3]);

        $this->assertEquals(
            [
                (object)[
                    'time' => new \DateTimeImmutable('2021-01-04 09:00'),
                    'activity' => 'Skiing',
                    'leader' => 'Ivan Ivanov'
                ],
                (object)[
                    'time' => new \DateTimeImmutable('2021-01-06 10:00'),
                    'activity' => 'Chess',
                    'leader' => 'Ivan Ivanov'
                ],
                (object)[
                    'time' => new \DateTimeImmutable('2021-01-07 11:00'),
                    'activity' => 'Swimming',
                    'leader' => 'Ivan Ivanov'
                ],
                (object)[
                    'time' => new \DateTimeImmutable('2021-01-11 09:00'),
                    'activity' => 'Skiing',
                    'leader' => 'Ivan Ivanov'
                ],
                (object)[
                    'time' => new \DateTimeImmutable('2021-01-13 10:00'),
                    'activity' => 'Chess',
                    'leader' => 'Ivan Ivanov'
                ],
                (object)[
                    'time' => new \DateTimeImmutable('2021-01-14 11:00'),
                    'activity' => 'Swimming',
                    'leader' => 'Ivan Ivanov'
                ],
            ],
            $calendar->constructCalendar(new \DateTimeImmutable('2021-01-01'), new \DateInterval('P2W'))
        );
    }

    public function testConstructVisitsCalendar()
    {
        $visitor = new Visitor('Tommy', 'Gun');
        $subscription = new Membership(new \DateTimeImmutable('2021-01-01'), new \DateInterval('P1M'), $visitor);
        $calendar = new TimeTable([$this->activity1, $this->activity2, $this->activity3]);
        $visits = $this->activity1->subscribe($visitor, $subscription);
        self::assertEquals(
            [
                (object)[
                    'time' => new \DateTimeImmutable('2021-01-04 09:00'),
                    'activity' => 'Skiing',
                    'leader' => 'Ivan Ivanov',
                    'visitor' => 'Tommy Gun',
                    'status' => 'planned'
                ],
                (object)[
                    'time' => new \DateTimeImmutable('2021-01-06 10:00'),
                    'activity' => 'Chess',
                    'leader' => 'Ivan Ivanov'
                ],
                (object)[
                    'time' => new \DateTimeImmutable('2021-01-07 11:00'),
                    'activity' => 'Swimming',
                    'leader' => 'Ivan Ivanov'
                ],
                (object)[
                    'time' => new \DateTimeImmutable('2021-01-11 09:00'),
                    'activity' => 'Skiing',
                    'leader' => 'Ivan Ivanov',
                    'visitor' => 'Tommy Gun',
                    'status' => 'planned'
                ],
                (object)[
                    'time' => new \DateTimeImmutable('2021-01-13 10:00'),
                    'activity' => 'Chess',
                    'leader' => 'Ivan Ivanov'
                ],
                (object)[
                    'time' => new \DateTimeImmutable('2021-01-14 11:00'),
                    'activity' => 'Swimming',
                    'leader' => 'Ivan Ivanov'
                ],
            ],
            $calendar->constructVisitsCalendar($visits, new \DateTimeImmutable('2021-01-01'), new \DateInterval('P2W'))
        );
    }
}
