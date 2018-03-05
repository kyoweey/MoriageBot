<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config/Config.php';
require_once __DIR__ . '/factory/DispatcherFactory.php';
require_once __DIR__ . '/factory/MoriageControllerFactory.php';
require_once __DIR__ . 'view/Reply.php';
require_once __DIR__ . 'MoriageController.php';

$dispatcher = DispatcherFactory::create();
$dispatcher->dispatch();

?>