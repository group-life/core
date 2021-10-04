<?php

namespace GroupLife\Core\tests\DataMapper;

use GroupLife\Core\DataMapper\VisitorMapper;
use GroupLife\Core\Test\TestCaseWithDb;
use GroupLife\Core\Visitor;

class VisitorMapperTest extends TestCaseWithDb
{
    /**
     * @throws \Doctrine\DBAL\Exception
     */
    public function testInsert()
    {
        $visitor = new Visitor('Petr', 'Petrov');
        $mapper = new VisitorMapper(self::$db);
        $mapper->insert($visitor);
        $visitorId = getDataObject($visitor)->id;
        self::assertEquals(
            [
                'id' => (string)$visitorId,
                'name' => 'Petr',
                'surname' => 'Petrov'
            ],
            self::$db->fetchAssociative("SELECT * FROM `Visitor` WHERE id = ?", [$visitorId])
        );
    }

    public function testFind()
    {
        $mapper = new VisitorMapper(self::$db);
        $newVisitor = $mapper->find(1);
        self::assertInstanceOf(Visitor::class, $newVisitor);
    }
}
