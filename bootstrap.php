<?php

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

require 'vendor/autoload.php';

$entityPaths = [
    'src/Entity/'
];

$dbParams = [
    'driver' => 'pdo_sqlite',
    'path' => 'db.sqlite'
];

$config = Setup::createAnnotationMetadataConfiguration($entityPaths, false, null, null, false);
$entityManager = EntityManager::create($dbParams, $config);