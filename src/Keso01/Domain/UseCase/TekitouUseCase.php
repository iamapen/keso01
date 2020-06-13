<?php

namespace Keso01\Domain\UseCase;

use Keso01\Domain\Filter\BlackWordFilter;

class TekitouUseCase
{

    public function invoke(string $input): array
    {
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
            '-u', getenv('MECAB_USER_DIC'),
        ];
        $words = (new \Keso01\Adapter\Mecab\Analyser\Popen(getenv('MECAB_BIN')))
            ->morphologicalAnalyse($input, $mecabOpt);

        // フィルタ
        $blackWordFilter = new BlackWordFilter();
        $words = $blackWordFilter->filter($words);

        return $words;
    }
}
