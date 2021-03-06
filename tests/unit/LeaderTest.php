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
        self::assertJsonStringEqualsJsonString('{
                "id": null,
                "name": "Ivan",
                "surname": "Ivanov"
            }', json_encode(self::leaderIvan(), JSON_PRETTY_PRINT));
    }

    private static function leaderIvan(): Leader
    {
        return new Leader('Ivan', 'Ivanov');
    }
}
