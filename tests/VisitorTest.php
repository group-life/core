<?php

namespace GroupLife\Core\tests;

use PHPUnit\Framework\TestCase;
use Core\Visitor;

class VisitorTest extends TestCase
{
    public function testReturnFullName()
    {
        $visitor = new Visitor("Vasya", "Pupkin");
        $this->assertEquals('My name is Vasya Pupkin', $visitor->returnFullName());
    }
}
