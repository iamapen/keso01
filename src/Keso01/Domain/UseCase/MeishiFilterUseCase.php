<?php

namespace Keso01\Domain\UseCase;

use Keso01\Domain\Filter\BlackWordFilter;
use Keso01\Domain\Filter\MeishiFilter;

class MeishiFilterUseCase
{

    public function invoke(string $input): array
    {
        // 前処理
        $normalizer = new \Keso01\Domain\Normalizer\BasicNormalizer();
        $input = $normalizer->normalize($input);

        // 形態素解析
        $mecabOpt = [
            '-u', getenv('MECAB_USER_DIC'),
        ];
        $words = (new \Keso01\Adapter\Mecab\Analyser\Popen(getenv('MECAB_BIN')))
            ->morphologicalAnalyse($input, $mecabOpt);

        // フィルタ
        $blackWordFilter = new BlackWordFilter();
        $words = $blackWordFilter->filter($words);

        // 名詞に限定
        $meishiFilter = new MeishiFilter();
        $words = $meishiFilter->onlyMeishi($words);

        return $words;
    }
}
