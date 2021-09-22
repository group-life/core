<?php

namespace GroupLife\Core\tests\DataMapper;

use GroupLife\Core\DataMapper\VisitorMapper;
use GroupLife\Core\Test\TestCaseWithDb;
use GroupLife\Core\Visitor;

class VisitorMapperTest extends TestCaseWithDb
{
    public function testInsert()
    {
        $visitor = new Visitor('Petr', 'Petrov');
        $mapper = new VisitorMapper(self::$db);
        $mapper->insert($visitor);
        self::assertEquals([], self::$db->fetchAllAssociative('SELECT * FROM `Visitor` WHERE id = 1'));
    }

//    public function testUpdate()
//    {
//    }
//
//    public function testFind()
//    {
//    }
}
