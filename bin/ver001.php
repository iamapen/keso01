#!/usr/bin/php
<?php declare(strict_types=1);
/**
 * ひとまずphp-mecabが動作する状態にしたもの
 * @uses php-mecab 0.6.0
 */

$inputFile = $argv[1] ?? null;
if ($inputFile === null) {
    echo sprintf('Usage: %s <inputFile>', basename(__FILE__)), "\n";
    exit(1);
}

$input = file_get_contents($inputFile);

// 前処理
$input = trim($input);
//$input = mb_convert_kana($input, 'ascKV', 'UTF-8');
$input = mb_convert_kana($input, 'asKV', 'UTF-8');
//$input = strtr($input, '"', '');
//$input = str_replace("\n", '', $input);
//$input = preg_replace("/[[\]【】\/\n★!?:;@`{}♪・※◎()、。「」~\\\\|]/u", '', $input);
$input = preg_replace("/[[\]【】\t\r\n★!?;@`{}♪・※◎()、。「」~\\\\|\/,.]/u", ' ', $input);

// 形態素解析
$mecabOpt = [
    '-O', 'wakati',
    '-u', realpath(__DIR__ . '/../storage/dic/user.dic'),
];
//$mecabOpt = [];

$words = explode(' ', doMorphologicalAnalysis($input, $mecabOpt));

// フィルタ
$words = array_unique($words);
$words = array_combine($words, $words);

$blackWords = [
    "\n",
    '!', '"', '#', '$', '%', '&', "'", '(', ')', '*', '+', ',', '~', '.', '/',
    '0', '1', '2', '3', '4', '5', '6', '7', '8', '9', ':', ';', '<', '=', '>', '?',
    '@', '[', '\\', ']', '^', '_',
    '`', '{', '~', '}', '~',
    '¥',
    '、', '。', '・', '～',
    '★', '【', '】', '♪', '◎', '※',
];
foreach ($blackWords as $blackWord) {
    unset($words[$blackWord]);
}

var_dump(array_values($words));

/**
 * 形態素解析を実行して返す
 * @param string $input
 * @param string[] $mecabOpt
 * @return string
 */
function doMorphologicalAnalysis(string $input, array $mecabOpt = []): string
{
    $tagger = new \Mecab\Tagger($mecabOpt);
    return $tagger->parse($input);
}
