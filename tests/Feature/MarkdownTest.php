<?php

namespace TechnoStupid\Press\Tests;

use Orchestra\Testbench\TestCase;
use TechnoStupid\Press\MarkdownParser;

class MarkdownTest extends TestCase
{
    /**@test */
    public function test()
    {
        $this->assertEquals('<h1>Heading</h1>',MarkdownParser::parse('# Heading'));
    }
}