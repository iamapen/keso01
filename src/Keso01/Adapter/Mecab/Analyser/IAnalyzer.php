<?php

namespace Keso01\Adapter\Mecab\Analyser;

interface IAnalyzer
{
    /**
     * mecabによる形態素解析実行
     * @param string $input
     * @param array $mecabOpt
     * @return array
     */
    public function morphologicalAnalyse(string $input, array $mecabOpt = []): array;
}
