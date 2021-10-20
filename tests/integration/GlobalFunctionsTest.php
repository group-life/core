<?php

namespace GroupLife\Core\tests\integration;

use PHPUnit\Framework\TestCase;

class GlobalFunctionsTest extends TestCase
{
    public function testGetMigrationsPath()
    {
        self::assertFileExists(getMigrationsPath() . '/Version20210913225128.php');
    }
}
