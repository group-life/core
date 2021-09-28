<?php

declare(strict_types=1);

namespace GroupLife\Core\tests\Activity;

use GroupLife\Core\Activity;
use GroupLife\Core\Leader;
use GroupLife\Core\Schedule;
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
        $object = new \stdClass();
    }

    public static function visit(): Visit
    {
        $leader = new Leader('Ivan', 'Ivanov');
        $schedule = new Schedule([
            new Schedule\DayRule(new \DateTimeImmutable('2021-01-01 10:00'))
        ]);
        return new Visit(
            new \DateTimeImmutable('2021-01-01 10:00'),
            new Activity('Swimming', $schedule, $leader),
            new Visitor('Ivan', 'Pupkin')
        );
    }
}
