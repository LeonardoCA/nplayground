<?php

require __DIR__ . '/../vendor/autoload.php';

$configurator = new Nette\Configurator;

//$configurator->setDebugMode('23.75.345.200'); // enable for your remote IP
//$configurator->setDebugMode(false);
$configurator->enableDebugger(__DIR__ . '/../log');

$configurator->setTempDirectory(__DIR__ . '/../temp');

$configurator->createRobotLoader()
	->addDirectory(__DIR__)
	->addDirectory(__DIR__ . '/../libs')
	->register();

$configurator->addConfig(__DIR__ . '/config/config.neon');
if (getenv('DEPLOYMENT_DESTINATION') == 'pagodabox') {
	$configurator->addConfig(__DIR__ . '/config/pagoda.production.php');
} else {
	$configurator->addConfig(__DIR__ . '/config/config.local.neon');
}

$container = $configurator->createContainer();

return $container;
