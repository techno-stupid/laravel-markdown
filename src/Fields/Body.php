<?php

namespace TechnoStupid\Press\Fields;

use TechnoStupid\Press\MarkdownParser;

class Body extends FieldContract
{
    public static function process($type, $value,$data)
    {
        return [
            $type => MarkdownParser::parse($value)
        ];
    }
}
