<?php

namespace Keso01\Domain\Normalizer;

class BasicNormalizer
{
    public function normalize($input): string
    {
        $result = $this->normalizeSpace($input);
        $result = trim($result);
        $result = $this->removeTilde($result);
        $result = $this->normalizeZenHan($result);
        $result = $this->normalizeHyphen($result);
        $result = $this->normalizeChouon($result);
        $result = $this->removeUselessSpace($result);
        return $result;
    }

    /**
     * ハイフン系の正規化
     *
     * 連続はひとつにまとめる
     * @param string $input
     * @return string
     */
    public function normalizeHyphen(string $input): string
    {
        return preg_replace('/[-˗֊‐‑‒–⁃⁻₋−]+/u', '-', $input);
    }

    /**
     * 長音記号の正規化
     *
     * 連続はひとつにまとめる
     * @param string $input
     * @return string
     */
    public function normalizeChouon(string $input): string
    {
        return preg_replace('/[﹣－ｰ—―─━ー]+/u', 'ー', $input);
    }

    /**
     * チルダの削除
     *
     * 削除してよいかは場合によるかも
     * @param string $input
     * @return string
     */
    public function removeTilde(string $input): string
    {
        return strtr(
            $input,
            [
                '~' => '',
                '∼' => '',
                '∾' => '',
                '〜' => '',
                '〰' => '',
                '～' => '',
            ]
        );
    }

    /**
     * 全角半角正規化
     * @param string $input
     * @return string
     */
    public function normalizeZenHan(string $input): string
    {
        $result = mb_convert_kana($input, 'asKV', 'UTF-8');
        $result = strtr($result, [
            // 半角にする
            '”' => '"',
            '’' => "'",
            '‘' => "`",
            '￥' => "¥", // U+00A5
            // 全角にする
            '=' => '＝',
        ]);
        return $result;
    }

    /**
     * スペース正規化
     * @param string $input
     * @return string
     */
    public function normalizeSpace(string $input): string
    {
        return preg_replace('/[\p{C}\p{Z}]++/u', ' ', $input);
    }

    /**
     * スペース削除
     *
     * 連続スペースはひとつに正規化されていることが前提
     * @param string $input
     * @return string
     */
    public function removeUselessSpace($input)
    {
        $latin = '\x{0000}-\x{007F}]';

        //$hiragana = '\x{3040}-\x{309F}'; // ひらがな
        $hiragana = '\p{Hiragana}'; // ひらがな
        //$katakana = '\x{30A0}-\x{30FF}'; // 全角カタカナ
        $katakana = '\p{Katakana}'; // 全角カタカナ
        //$cjkUnifiedIdeographs = '\x{4E00}-\x{9FFF}';    // CJK統合漢字
        $kanji = '\p{Han}'; // CJK漢字
        $cjkSymbosAndPunctuation = '\x{3000}-\x{303F}'; // CJKの記号及び句読点
        $halfwidhAndFullwidthForms = '\x{FF00}-\x{FFEF}'; // 全角英数、半角カナ

        $class = "{$hiragana}{$katakana}{$kanji}{$cjkSymbosAndPunctuation}{$halfwidhAndFullwidthForms}";

        $result = $input;
        // 全角 - 全角間のスペースを削除
        do {
            $result = preg_replace("/([{$class}]+) ([{$class}]+)/u", '$1$2', $result, -1, $count);
        } while ($count > 0);
        // 全角 - latin間のスペースを削除
        do {
            $result = preg_replace("/([{$class}]+) ([{$latin}]+)/u", '$1$2', $result, -1, $count);
        } while ($count > 0);
        // latin - 全角間のスペースを削除
        do {
            $result = preg_replace("/([{$latin}]+) ([{$class}]+)/u", '$1$2', $result, -1, $count);
        } while ($count > 0);

        return $result;
    }
}
