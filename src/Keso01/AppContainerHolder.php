<?php

namespace Keso01;

use Keso01\AppContainerInterface;

/**
 * Containerをstaticに持つだけのもの
 */
class AppContainerHolder
{
    /** @var AppContainerInterface */
    private static $container;

    /**
     * @return AppContainerInterface
     */
    public static function instance()
    {
        if (!isset(self::$container)) {
            throw new \RuntimeException('not initialized');
        }
        return self::$container;
    }

    /**
     * @param AppContainerInterface $container
     */
    public static function init(AppContainerInterface $container)
    {
        static::$container = $container;
    }
}
