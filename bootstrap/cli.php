<?php declare(strict_types=1);
require __DIR__ . '/bootstrap.php';

/** @var $container \Keso01\AppContainerInterface */
$container = require __DIR__ . '/container.php';
\Keso01\AppContainerHolder::init($container);

\Monolog\ErrorHandler::register($container->errorLogger());
