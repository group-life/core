<?php

declare(strict_types=1);

namespace GroupLife\Core\tests\integration;

use GroupLife\Core\Test\TestCaseWithDb;

class DatabaseIsAvailableTest extends TestCaseWithDb
{
    public function testConnection(): void
    {
        self::assertEquals('test.db', basename(self::$db->getDatabase()));
    }

    public function testSchemaIsPresent(): void
    {
        self::$db->executeQuery('SELECT * FROM schedule');
    }
}
