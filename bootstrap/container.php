<?php declare(strict_types=1);

/**
 * コンテナ設定
 * @return AppContainerInterface
 */

use Keso01\AppContainerInterface;

$containerBuilder = new DI\ContainerBuilder(\Keso01\AppContainer::class);

/** Logger */
$containerBuilder->addDefinitions(__DIR__ . '/container/logger.php');

return $containerBuilder->build();
