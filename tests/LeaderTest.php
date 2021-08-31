<?php

declare(strict_types = 1);

namespace GroupLife\Core;

use PHPUnit\Framework\TestCase;

class LeaderTest extends TestCase
{

    public function testGetFullName()
    {
        $leader = new Leader('Ivan', 'Ivanov');
        $this->assertEquals('Ivan Ivanov', $leader->getFullName());
    }
}
