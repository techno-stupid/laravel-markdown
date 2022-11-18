<?php

namespace TechnoStupid\Press;

class MarkdownParser
{
    public static function parse($string)
    {
        return \Parsedown::instance()->text($string);
    }
}