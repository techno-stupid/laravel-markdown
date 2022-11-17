<?php

namespace TechnoStupid\Press;

class MarkdownParser
{
    public static function parse($string)
    {
        $parseDown = new \Parsedown();
        return $parseDown->text($string);
    }
}