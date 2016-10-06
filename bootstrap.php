<?php
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

require_once "vendor/autoload.php";
$paths = array("model/entity");
// Create a simple "default" Doctrine ORM configuration for Annotations
$isDevMode = true;
$config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);

// database configuration parameters
$conn = array(
    'driver' => 'pdo_mysql',
    'user' => 'grupo17',
    'password' => 'Reev5Pho8o',
    'host' => 'localhost',
    'dbname' => 'grupo17',
);

// obtaining the entity manager
$entityManager = EntityManager::create($conn, $config);

?>
