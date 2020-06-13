#!/usr/bin/php
<?php declare(strict_types=1);
require_once __DIR__ . '/../bootstrap/cli.php';
/**
 * ずさんな前処理をしたもの
 */

$inputFile = $argv[1] ?? null;
if ($inputFile === null) {
    echo sprintf('Usage: %s <inputFile>', basename(__FILE__)), "\n";
    exit(1);
}

$input = file_get_contents($inputFile);

$words = (new \Keso01\Domain\UseCase\TekitouUseCase())->invoke($input);

var_dump(array_keys($words));
