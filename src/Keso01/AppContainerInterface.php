<?php

namespace Keso01;

use Psr\Log\LoggerInterface;

interface AppContainerInterface
{
    const LOGGER_APP = \Psr\Log\LoggerInterface::class;
    const LOGGER_ERROR = 'LOGGER_ERROR';

    public function logger(): LoggerInterface;

    public function errorLogger(): LoggerInterface;

}
