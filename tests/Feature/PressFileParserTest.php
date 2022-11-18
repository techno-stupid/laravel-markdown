<?php

namespace TechnoStupid\Press\Tests;

use Carbon\Carbon;
use Orchestra\Testbench\TestCase;
use PHPUnit\Util\Test;
use TechnoStupid\Press\PressFileParser;

class PressFileParserTest extends TestCase
{
    /**@test */ //The head and body gets split
    public function test_the_head_and_body_gets_split()
    {
        $pressFileParser = new PressFileParser(__DIR__.'/../blogs/MarkFile1.md');
        $data = $pressFileParser->getRawData();
        $this->assertRegExp('/title: My Title/', $data[1]);
        $this->assertRegExp('/description: Description here/', $data[1]);
        $this->assertRegExp('/This is the body/', $data[2]);
    }

    public function test_a_string_can_also_be_used_instead()
    {
        $pressFileParser = new PressFileParser("---\ntitle: My Title\n---\nBlog post body here");
        $data = $pressFileParser->getRawData();
        $this->assertRegExp('/title: My Title/', $data[1]);
        $this->assertRegExp('/Blog post body here/', $data[2]);
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
        $this->assertEquals("<h1>Heading</h1>\n<p>This is the body</p>", $data['body']);
    }

    public function test_a_date_field_gets_parsed()
    {
        $pressFileParser = new PressFileParser("---\ndate: May 14, 1988\n---\n");
        $data = $pressFileParser->getData();

        $this->assertInstanceOf(Carbon::class, $data['date']);
        $this->assertEquals('05/14/1988', $data['date']->format('m/d/Y'));
    }

    public function test_extra_field_gets_saved()
    {
        $pressFileParser = new PressFileParser("---\nauthor: Mahady Hasan\n---\n");
        $data = $pressFileParser->getData();
        $this->assertEquals(json_encode(['author' => 'Mahady Hasan']), $data['extra']);
    }

    public function test_multiple_aditional_fields_into_extra()
    {
        $pressFileParser = new PressFileParser("---\nauthor: Mahady Hasan\ncategory: Science\n---\n");
        $data = $pressFileParser->getData();
        $this->assertEquals(json_encode(['author' => 'Mahady Hasan','category' => 'Science']), $data['extra']);
    }
}