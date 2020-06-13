<?php

namespace Keso01\Normalizer;

class BasicNormalizerTest extends \PHPUnit\Framework\TestCase
{
    private $sut;

    function setUp(): void
    {
        parent::setUp();
        $this->sut = new BasicNormalizer();
    }

    function test_normalize()
    {
        $this->markTestIncomplete();
    }

    public function testNormalizeZenHan()
    {
        // 半角にする
        $this->assertSame('a', $this->sut->normalizeZenHan('ａ'));
        $this->assertSame('A', $this->sut->normalizeZenHan('Ａ'));
        $this->assertSame('1', $this->sut->normalizeZenHan('１'));
        $this->assertSame(' ', $this->sut->normalizeZenHan('　'));
        $this->assertSame('!', $this->sut->normalizeZenHan('！'));
        $this->assertSame('"', $this->sut->normalizeZenHan('”'));
        $this->assertSame('#', $this->sut->normalizeZenHan('＃'));
        $this->assertSame('$', $this->sut->normalizeZenHan('＄'));
        $this->assertSame('%', $this->sut->normalizeZenHan('％'));
        $this->assertSame('&', $this->sut->normalizeZenHan('＆'));
        $this->assertSame('\'', $this->sut->normalizeZenHan('’'));
        $this->assertSame('(', $this->sut->normalizeZenHan('（'));
        $this->assertSame(')', $this->sut->normalizeZenHan('）'));
        $this->assertSame('^', $this->sut->normalizeZenHan('＾'));
        $this->assertSame('|', $this->sut->normalizeZenHan('｜'));
        $this->assertSame('@', $this->sut->normalizeZenHan('＠'));
        $this->assertSame('`', $this->sut->normalizeZenHan('‘'));
        $this->assertSame('[', $this->sut->normalizeZenHan('［'));
        $this->assertSame(']', $this->sut->normalizeZenHan('］'));
        $this->assertSame('{', $this->sut->normalizeZenHan('｛'));
        $this->assertSame('}', $this->sut->normalizeZenHan('｝'));
        $this->assertSame(';', $this->sut->normalizeZenHan('；'));
        $this->assertSame(':', $this->sut->normalizeZenHan('：'));
        $this->assertSame('+', $this->sut->normalizeZenHan('＋'));
        $this->assertSame('*', $this->sut->normalizeZenHan('＊'));
        $this->assertSame('<', $this->sut->normalizeZenHan('＜'));
        $this->assertSame('>', $this->sut->normalizeZenHan('＞'));
        $this->assertSame(',', $this->sut->normalizeZenHan('，'));
        $this->assertSame('.', $this->sut->normalizeZenHan('．'));
        $this->assertSame('/', $this->sut->normalizeZenHan('／'));
        $this->assertSame('?', $this->sut->normalizeZenHan('？'));
        $this->assertSame('_', $this->sut->normalizeZenHan('＿'));
        $this->assertSame('¥', $this->sut->normalizeZenHan('￥'), 'U+00A5');

        // 全角にする
        $this->assertSame('ガ', $this->sut->normalizeZenHan('ｶﾞ'));
        $this->assertSame('、', $this->sut->normalizeZenHan('､'));
        $this->assertSame('。', $this->sut->normalizeZenHan('｡'));
        $this->assertSame('・', $this->sut->normalizeZenHan('･'));
        $this->assertSame('＝', $this->sut->normalizeZenHan('='));
        $this->assertSame('「', $this->sut->normalizeZenHan('｢'));
        $this->assertSame('」', $this->sut->normalizeZenHan('｣'));
    }

    public function testNormalizeChouon()
    {
        $this->assertSame('ー', $this->sut->normalizeChouon('ーー'), 'U+30FC');
        $this->assertSame('ー', $this->sut->normalizeChouon('－－'), 'U+FF0D');
        $this->assertSame('ー', $this->sut->normalizeChouon('ｰｰ'), 'U+FF70');
        $this->assertSame('ー', $this->sut->normalizeChouon('——'), 'U+2014');
        $this->assertSame('ー', $this->sut->normalizeChouon('――'), 'U+2015');
        $this->assertSame('ー', $this->sut->normalizeChouon('──'), 'U+2500');
        $this->assertSame('ー', $this->sut->normalizeChouon('━━'), 'U+2501');
    }

    public function testRemoveTilde()
    {
        $this->assertSame('', $this->sut->removeTilde('~'));
        $this->assertSame('', $this->sut->removeTilde('∼'));
        $this->assertSame('', $this->sut->removeTilde('∾'));
        $this->assertSame('', $this->sut->removeTilde('〜'));
        $this->assertSame('', $this->sut->removeTilde('〰'));
        $this->assertSame('', $this->sut->removeTilde('～'));
    }

    public function testNormalizeHyphen()
    {
        $this->assertSame('-', $this->sut->normalizeHyphen('--'), 'U+002D');
        $this->assertSame('-', $this->sut->normalizeHyphen('˗˗'), 'U+02D7');
        $this->assertSame('-', $this->sut->normalizeHyphen('֊֊'), 'U+058A');
        $this->assertSame('-', $this->sut->normalizeHyphen('‐‐'), 'U+2010');
        $this->assertSame('-', $this->sut->normalizeHyphen('‑‑'), 'U+2011');
        $this->assertSame('-', $this->sut->normalizeHyphen('‒‒'), 'U+2012');
        $this->assertSame('-', $this->sut->normalizeHyphen('––'), 'U+2013');
        $this->assertSame('-', $this->sut->normalizeHyphen('⁃⁃'), 'U+2043');
        $this->assertSame('-', $this->sut->normalizeHyphen('⁻⁻'), 'U+207B');
        $this->assertSame('-', $this->sut->normalizeHyphen('₋₋'), 'U+208B');
        $this->assertSame('-', $this->sut->normalizeHyphen('−−'), 'U+2212');
    }

    function test_normalizeSpace()
    {
        $this->assertSame(' ', $this->sut->normalizeSpace(' '));
        $this->assertSame(' ', $this->sut->normalizeSpace('  '));
        $this->assertSame(' ', $this->sut->normalizeSpace('　'));
        $this->assertSame(' ', $this->sut->normalizeSpace('　　'));
        $this->assertSame(' ', $this->sut->normalizeSpace("\t"));
    }

    function test_removeUselessSpace()
    {
        $this->assertSame('ひらがな', $this->sut->removeUselessSpace('ひら がな'));
        $this->assertSame('カタカナ', $this->sut->removeUselessSpace('カタ カナ'));
        $this->assertSame('漢字', $this->sut->removeUselessSpace('漢 字'));
        $this->assertSame('ａｂｃｄ', $this->sut->removeUselessSpace('ａｂ ｃｄ'));
        $this->assertSame('１２３４', $this->sut->removeUselessSpace('１２ ３４'));
        $this->assertSame('ｶﾀｶﾅ', $this->sut->removeUselessSpace('ｶﾀ ｶﾅ'));

        $this->assertSame('ひらカタひら', $this->sut->removeUselessSpace('ひら カタ ひら'));
        $this->assertSame('ひらカタ漢字', $this->sut->removeUselessSpace('ひら カタ 漢字'));
        $this->assertSame('カタひら漢字', $this->sut->removeUselessSpace('カタ ひら 漢字'));
        $this->assertSame('ひらカタ 12 ab', $this->sut->removeUselessSpace('ひら カタ 12 ab'));
        $this->assertSame('ab 12 ひらカタ', $this->sut->removeUselessSpace('ab 12 ひら カタ'));

        // latinのスペースは消さない
        $this->assertSame('ab cd', $this->sut->removeUselessSpace('ab cd'));
        $this->assertSame('12 34', $this->sut->removeUselessSpace('12 34'));
        $this->assertSame('#$ %&', $this->sut->removeUselessSpace('#$ %&'));
    }
}
