<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config/Config.php';
require_once __DIR__ . '/factory/DispatcherFactory.php';
require_once __DIR__ . '/factory/MoriageControllerFactory.php';
require_once __DIR__ . '/factory/ReplyFactory.php';
require_once __DIR__ . '/view/Reply.php';
require_once __DIR__ . '/controller/MoriageController.php';
require_once __DIR__ . '/Dispatcher.php';

$dispatcher = DispatcherFactory::create();
$dispatcher->dispatch();

?>