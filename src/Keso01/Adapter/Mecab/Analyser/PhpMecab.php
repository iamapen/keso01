<?php

namespace Keso01\Adapter\Mecab\Analyser;

/**
 * php-mecab による実装
 * @uses php-mecab 0.6.0
 */
class PhpMecab implements IAnalyzer
{
    public function morphologicalAnalyse(string $input, array $mecabOpt = []): array
    {
        $tagger = new \Mecab\Tagger($mecabOpt);
        $strResult = $tagger->parse($input);

        $result = [];
        foreach (explode("\n", $strResult) as $strRow) {
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
