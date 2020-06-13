<?php

namespace Keso01\Domain\Filter;

class BlackWordFilter
{

    public function filter(array $words): array
    {
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

        return $words;
    }
}
