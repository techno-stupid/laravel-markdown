<?php

namespace TechnoStupid\Press\Tests;

use Orchestra\Testbench\TestCase;
use PHPUnit\Util\Test;
use TechnoStupid\Press\PressFileParser;

class PressFileParserTest extends TestCase
{
    /**@test */ //The head and body gets split
    public function test_the_head_and_body_gets_split()
    {
        $pressFileParser = new PressFileParser(__DIR__.'/../blogs/MarkFile1.md');
        $data = $pressFileParser->getData();
        $this->assertRegExp('/title: My Title/', $data[1]);
        $this->assertRegExp('/description: Description here/', $data[1]);
        $this->assertRegExp('/This is the body/', $data[2]);
    }

    public function test_each_head_fields_get_seperated()
    {
        $pressFileParser = (new PressFileParser(__DIR__.'/../blogs/MarkFile1.md'));
        $data = $pressFileParser->getData();
        $this->assertEquals('My Title', $data['title']);
        $this->assertEquals('Description here', $data['description']);
    }

    public function test_the_body_gets_saved_and_trimmed()
    {
        $pressFileParser = (new PressFileParser(__DIR__.'/../blogs/MarkFile1.md'));
        $data = $pressFileParser->getData();
        $this->assertEquals("# Heading\n\nThis is the body", $data['body']);
    }
}