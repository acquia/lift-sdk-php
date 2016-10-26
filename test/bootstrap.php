<?php

$autoloadFile = __DIR__ . '/../vendor/autoload.php';
if (!file_exists($autoloadFile)) {
    throw new RuntimeException('Install dependencies to run phpunit.');
}
$loader = require($autoloadFile);

$loader->add('Acquia\LiftClient\\', __DIR__ . '/test');