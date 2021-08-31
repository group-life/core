<?php

declare(strict_types = 1);

namespace GroupLife\Core;

use PHPUnit\Framework\TestCase;

class VisitorTest extends TestCase
{
    public function testReturnFullName()
    {
        $visitor = new Visitor("Vasya", "Pupkin");
        $this->assertEquals('Vasya Pupkin', $visitor->getFullName());
    }
}
