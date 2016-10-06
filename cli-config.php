<?php

require 'vendor/autoload.php';
use Doctrine\ORM\Tools\Setup;

$path = array('Model/Entity');
$devMode = true;

$config = Setup::createAnnotationMetadataConfiguration($path, $devMode);

$connectionOptions = array(
    'driver'   => 'pdo_mysql',
    'host'     => 'dfsdf',
    'dbname'   => 'hda',
    'user'     => 'root',
    'password' => '',
);

$em = \Doctrine\ORM\EntityManager::create($connectionOptions, $config);

?>
