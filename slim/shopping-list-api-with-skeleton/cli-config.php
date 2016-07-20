<?php

use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

require "vendor/autoload.php";

$settings = include 'app/config/app.php';
$settings = $settings['settings']['database'];

$config = Setup::createAnnotationMetadataConfiguration(
    $settings['meta']['entity_path'],
    $settings['meta']['auto_generate_proxies'],
    $settings['meta']['proxy_dir'],
    $settings['meta']['cache']
);




$em = EntityManager::create($settings['connection'], $config);

return ConsoleRunner::createHelperSet($em);
