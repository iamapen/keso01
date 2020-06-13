<?php

namespace Keso01\Adapter\Mecab\Analyser;

/**
 * proc_open() による実装
 * @package Keso01\Adapter\Mecab\Analyser
 */
class Popen implements IAnalyzer
{
    private $mecabBin = '/usr/bin/mecab';

    public function __construct(?string $mecabBin = null)
    {
        if (strval($mecabBin) !== '') {
            $this->mecabBin = $mecabBin;
        }
    }

    public function morphologicalAnalyse(string $input, array $mecabOpt = []): array
    {
        $descriptorspec = [
            ['pipe', 'r'],
            ['pipe', 'w'],
            ['pipe', 'w'],
        ];
        $stdout = null;
        $stderr = null;
        $cmd = sprintf('%s %s', $this->mecabBin, implode(' ', $mecabOpt));
        $ph = proc_open($cmd, $descriptorspec, $pipes);
        if (!is_resource($ph)) {
            throw new \RuntimeException('proc_open() failed');
        }

        fwrite($pipes[0], $input . "\n");
        fclose($pipes[0]);

        $stdout = stream_get_contents($pipes[1]);
        fclose($pipes[1]);

        $stderr = stream_get_contents($pipes[2]);
        fclose($pipes[2]);
        $exitCode = proc_close($ph);

        if ($exitCode !== 0) {
            throw new \RuntimeException(sprintf(
                'proc_open() exit status "%s", stdout "%s"', $exitCode, $stdout
            ));
        }

        $result = [];
        foreach (explode("\n", $stdout) as $strRow) {
            if ($strRow === '' || $strRow === 'EOS') {
                continue;
            }
            list($word, $strParts) = explode("\t", $strRow);
            $parts = explode(',', $strParts);
            $result[$word] = [
                'hyousou' => $word, // 表層形
                'hinshi' => $parts[0], // 品詞
                'hinshiSaibunrui1' => $parts[1], // 品詞細分類1
                'hinshiSaibunrui2' => $parts[2], // 品詞細分類2
                'hinshiSaibunrui3' => $parts[3], // 品詞細分類3
                'katsuyokei' => $parts[4], // 活用型
                'katsuyogata' => $parts[5], // 活用形
                'genkei' => $parts[6],  // 原形
                'yomi' => $parts[7] ?? '', // 読み
                'hatsuon' => $parts[8] ?? '', // 発音
            ];
        }

        return $result;
    }
}
