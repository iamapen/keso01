<?php declare(strict_types=1);

/**
 * logger設定
 * @return array
 */

use Psr\Log\LoggerInterface;
use Keso01\AppContainer;
use Monolog\Logger;
use Monolog\Handler;
use Monolog\Formatter;
use Monolog\Processor;

use Keso01\AppContainerInterface;

return [
    // アプリログ
    LoggerInterface::class => function (AppContainer $c) {
        $logger = new Logger('app');
        $streamHandler = new Handler\StreamHandler(
            getenv('LOG_DIR') . '/' . PHP_SAPI . '.log', getenv('LOG_LEVEL'), true, 0666
        );
        $streamHandler->setFormatter(new Formatter\LineFormatter(null, 'Y-m-d H:i:s.u', true));
        $logger->pushHandler($streamHandler);
        $logger->pushProcessor(new Processor\ProcessIdProcessor())
            ->pushProcessor(new Processor\MemoryUsageProcessor())
            ->pushProcessor(new Processor\MemoryPeakUsageProcessor())
            ->pushProcessor(new Processor\IntrospectionProcessor(
                Logger::DEBUG, ['Monolog\\']
            ));

        $errorFileHandler = new Handler\StreamHandler(
            getenv('LOG_DIR') . '/error.log', Logger::WARNING, true, 0666
        );
        $errorFileHandler->setFormatter(
            (function () {
                $f = new Formatter\LineFormatter(null, 'Y-m-d H:i:s.u', true);
                $f->includeStacktraces(true);
                return $f;
            })()
        );
        $logger->pushHandler($errorFileHandler);
        return $logger;
    },

    // エラーログ
    AppContainerInterface::LOGGER_ERROR => function (AppContainer $c) {
        $logger = new Logger('error');
        $errorFileHandler = new Handler\StreamHandler(
            getenv('LOG_DIR') . '/error.log', Logger::WARNING, true, 0666
        );
        $errorFileHandler->setFormatter(
            (function () {
                $f = new Formatter\LineFormatter(null, 'Y-m-d H:i:s.u', true);
                $f->includeStacktraces(true);
                return $f;
            })()
        );

        $stdErrHandler = new Handler\StreamHandler('php://stderr', getenv('LOG_LEVEL'));
        $stdErrHandler->setFormatter(new Formatter\LineFormatter(null, 'Y-m-d H:i:s.u', true));

        $logger->pushHandler($errorFileHandler)
            ->pushHandler($stdErrHandler)
            ->pushProcessor(new Processor\ProcessIdProcessor())
            ->pushProcessor(new Processor\MemoryUsageProcessor())
            ->pushProcessor(new Processor\MemoryPeakUsageProcessor());

        return $logger;
    },
];
