<?php

namespace Keso01\Domain\Filter;

class MeishiFilter
{
    /**
     * 名詞に限定する
     * @param array $nodes
     * @return array
     */
    public function onlyMeishi(array $nodes): array
    {
        foreach ($nodes as $key => $node) {
            if ($node['hinshi'] !== '名詞') {
                unset($nodes[$key]);
            }
        }
        return $nodes;
    }

    /**
     * 名詞に限定する
     * 名詞-数 は除く
     * @param array $nodes
     * @return array
     */
    public function onlyMeishiWithoutNumber(array $nodes): array
    {
        foreach ($nodes as $key => $node) {
            if ($node['hinshi'] !== '名詞') {
                unset($nodes[$key]);
            }

            if ($node['hinshiSaibunrui1'] === '数') {
                unset($nodes[$key]);
            }
        }
        return $nodes;
    }
}
