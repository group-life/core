<?php

namespace GroupLife\Core;

use GroupLife\Core\Schedule\WeekdayRule;
use PHPUnit\Framework\TestCase;

class TimeTableTest extends TestCase
{

    public function testConstructCalendar()
    {
        $leader = new Leader('Ivan', 'Ivanov');
        $schedule1 = new Schedule([new WeekdayRule('Monday', '09:00')]);
        $activity1 = new Activity('Skiing', $schedule1, $leader);
        $schedule2 = new Schedule([new WeekdayRule('Wednesday', '10:00')]);
        $activity2 = new Activity('Chess', $schedule2, $leader);
        $schedule3 = new Schedule([new WeekdayRule('Thursday', '11:00')]);
        $activity3 = new Activity('Swimming', $schedule3, $leader);
        $calendar = new TimeTable([$activity1, $activity2, $activity3]);
        $this->assertEquals(
            [
                (object)[
                    'time' => new \DateTime('2021-01-04 09:00'),
                    'activity' => 'Skiing',
                    'leader' => 'Ivan Ivanov'
                ],
                (object)[
                    'time' => new \DateTime('2021-01-06 10:00'),
                    'activity' => 'Chess',
                    'leader' => 'Ivan Ivanov'
                ],
                (object)[
                    'time' => new \DateTime('2021-01-07 11:00'),
                    'activity' => 'Swimming',
                    'leader' => 'Ivan Ivanov'
                ],
                (object)[
                    'time' => new \DateTime('2021-01-11 09:00'),
                    'activity' => 'Skiing',
                    'leader' => 'Ivan Ivanov'
                ],
                (object)[
                    'time' => new \DateTime('2021-01-13 10:00'),
                    'activity' => 'Chess',
                    'leader' => 'Ivan Ivanov'
                ],
                (object)[
                    'time' => new \DateTime('2021-01-14 11:00'),
                    'activity' => 'Swimming',
                    'leader' => 'Ivan Ivanov'
                ],
            ],
            $calendar->constructCalendar(new \DateTime('2021-01-01'), new \DateInterval('P2W'))
        );
    }
}
