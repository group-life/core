<?php

declare(strict_types=1);

namespace GroupLife\Core\tests\Activity;

use GroupLife\Core\Activity;
use GroupLife\Core\Visitor;
use PHPUnit\Framework\TestCase;
use GroupLife\Core\Activity\Visit;

class VisitTest extends TestCase
{
    public function testCanBeConstructed()
    {
        $visit = new Visit(new \DateTime('2021-01-01 10:00'), 'Swimming', new Visitor('Ivan', 'Pupkin'));
        $this->assertIsObject($visit);
    }
}
