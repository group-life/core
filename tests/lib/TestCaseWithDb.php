<?php

declare(strict_types=1);

namespace GroupLife\Core\Test;

use Doctrine\DBAL;

abstract class TestCaseWithDb extends \PHPUnit\Framework\TestCase
{
    /**
     * @var DBAL\Connection;
     */
    protected static $db;

    public static function setUpBeforeClass(): void
    {
        self::$db = DBAL\DriverManager::getConnection([
            'url' => 'sqlite:///' . __DIR__ . '/test.db'
        ]);
    }
}
