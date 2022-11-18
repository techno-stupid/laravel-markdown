<?php

namespace TechnoStupid\Press;

use Illuminate\Support\Facades\File;

class PressFileParser
{
    protected $filename;
    protected $data;

    public function __construct($filename)
    {
        $this->filename = $filename;
        $this->splitFile();
        $this->explodeData();
    }

    public function getData()
    {
        return $this->data;
    }

    protected function splitFile()
    {
        preg_match(
            '/^\-{3}(.*?)\-{3}(.*)/s',
            File::get($this->filename),
            $this->data
        );
    }

    protected function explodeData()
    {
        foreach(explode("\n",trim($this->data[1])) as $fieldString)
        {
            $string = str_replace("\r", '', $fieldString);
            preg_match('/(.*):\s?(.*)/',$string,$fieldArray);
            $this->data[$fieldArray[1]] = $fieldArray[2];
        }
        $body =  str_replace("\r", '', trim($this->data[2]));
        $this->data['body'] = $body;
    }
}