<?php

declare(strict_types=1);

namespace GroupLife\Core\tests\Activity;

use GroupLife\Core\Activity;
use PHPUnit\Framework\TestCase;
use GroupLife\Core\Activity\Visit;

class VisitTest extends TestCase
{
    public function testCanBeConstructed()
    {
        $visit = new Visit(new \DateTime('2021-01-01 10:00'), new Activity('Swimming'));
        $this->assertIsObject($visit);
    }
}
