<?php
$loader = include __DIR__ . '/../vendor/autoload.php';

if (!$loader)
	die('Load composer and install dependencies before test running');

define('DOMNAVIGATOR_FIXTURES_DIR', realpath(__DIR__.'/Fixtures'));

$loader->add('DOMNavigator\Tests', __DIR__);