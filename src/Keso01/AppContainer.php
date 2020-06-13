<?php

namespace Keso01;

use Psr\Log\LoggerInterface;

class AppContainer extends \DI\Container implements AppContainerInterface
{
    public function logger(): LoggerInterface
    {
        return $this->get(AppContainerInterface::LOGGER_APP);
    }

    public function errorLogger(): LoggerInterface
    {
        return $this->get(AppContainerInterface::LOGGER_ERROR);
    }
}
