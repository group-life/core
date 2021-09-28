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
        self::assertJsonStringEqualsJsonString('{
            "id": null,
            "name": "Vasya",
            "surname": "Pupkin"
        }', json_encode(self::visitorVasya(), JSON_PRETTY_PRINT));
    }

    private static function visitorVasya(): Visitor
    {
        return new Visitor('Vasya', 'Pupkin');
    }
}
