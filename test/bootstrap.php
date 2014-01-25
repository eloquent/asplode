<?php

$autoloader = require __DIR__ . '/../vendor/autoload.php';
$autoloader->add('Eloquent\Asplode\Test', array(__DIR__ . '/src'));

if (class_exists('Phake')) {
    Phake::setClient(Phake::CLIENT_PHPUNIT);
}
