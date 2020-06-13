<?php declare(strict_types=1);

/**
 * 共通bootstrap
 */

use Psr\Log\LogLevel;

require __DIR__ . '/../vendor/autoload.php';

/*
 * 環境変数
 */
putenv('APP_ROOT=' . realpath(__DIR__ . '/../'));
$dotenv = \Dotenv\Dotenv::createUnsafeImmutable(__DIR__ . '/../');
$dotenv->load();
$dotenv->required('APP_ROOT');
$dotenv->required('STORAGE_DIR');
$dotenv->required('LOG_DIR');
$dotenv->required('LOG_LEVEL')->allowedValues([
    LogLevel::DEBUG, LogLevel::INFO, LogLevel::NOTICE,
    LogLevel::WARNING, LogLevel::ERROR,
    LogLevel::CRITICAL, LogLevel::ALERT, LogLevel::EMERGENCY,
]);

/*
 * php.ini
 */
ini_set('date.timezone', 'Asia/Tokyo');
//ini_set('error_log', getenv('LOG_DIR') . '/error.log');
