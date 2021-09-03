<?php

declare(strict_types=1);

namespace GroupLife\Core;

use PHPUnit\Framework\TestCase;

class ActivityTest extends TestCase
{

    public function testGetName()
    {
        $activity = new Activity('Горные лыжи');
        $this->assertEquals('Горные лыжи', $activity->getName());
    }
}