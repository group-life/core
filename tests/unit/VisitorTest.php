<?php

declare(strict_types=1);

namespace GroupLife\Core\tests;

use PHPUnit\Framework\TestCase;
use GroupLife\Core\Visitor;

class VisitorTest extends TestCase
{
    public function testReturnFullName()
    {
        $this->assertEquals('Vasya Pupkin', self::visitorVasya()->getFullName());
    }
    public function testJsonSerialize()
    {
        $object = new \stdClass();
        $object->id = null;
        $object->name = 'Vasya';
        $object->surname = 'Pupkin';
        self::assertEquals($object, getDataObject(self::visitorVasya()));
    }

    private static function visitorVasya(): Visitor
    {
        return new Visitor('Vasya', 'Pupkin');
    }
}
