<?php

require 'vendor/autoload.php';

use Doctrine\DBAL\DriverManager;
use Doctrine\Migrations\Configuration\Connection\ExistingConnection;
use Doctrine\Migrations\DependencyFactory;
use Doctrine\Migrations\Configuration\Migration\PhpFile;

$config = new PhpFile('migrations.php'); // Or use one of the Doctrine\Migrations\Configuration\Configuration\* loaders

$conn = DriverManager::getConnection(['driver' => 'pdo_sqlite', 'path' => './tests/lib/test.db']);

return DependencyFactory::fromConnection($config, new ExistingConnection($conn));
