<?php

declare(strict_types=1);

namespace GroupLife\Core\tests;

use GroupLife\Core\Leader;
use PHPUnit\Framework\TestCase;

class LeaderTest extends TestCase
{

    public function testGetFullName()
    {
        $this->assertEquals('Ivan Ivanov', self::leaderIvan()->getFullName());
    }

    public function testJsonSerialize()
    {
        $object = new \stdClass();
        $object->id = null;
        $object->name = 'Ivan';
        $object->surname = 'Ivanov';
        self::assertEquals($object, getDataObject(self::leaderIvan()));
    }

    private static function leaderIvan(): Leader
    {
        return $leader = new Leader('Ivan', 'Ivanov');
    }
}
