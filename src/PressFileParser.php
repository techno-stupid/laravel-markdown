<?php

namespace TechnoStupid\Press;

use Carbon\Carbon;
use Illuminate\Support\Facades\File;

class PressFileParser
{
    protected $filename;
    protected $data;
    protected $rawData;

    public function __construct($filename)
    {
        $this->filename = $filename;
        $this->splitFile();
        $this->explodeData();
        $this->processFields();
    }

    public function getData()
    {
        return $this->data;
    }

    public function getRawData()
    {
        return $this->rawData;
    }
 
    protected function splitFile()
    {
        preg_match(
            '/^\-{3}(.*?)\-{3}(.*)/s',
            File::exists($this->filename) ? File::get($this->filename) : $this->filename,
            $this->rawData
        );
    }

    protected function explodeData()
    {
        foreach(explode("\n",trim($this->rawData[1])) as $fieldString)
        {
            $string = str_replace("\r", '', $fieldString);
            preg_match('/(.*):\s?(.*)/',$string,$fieldArray);
            $this->data[$fieldArray[1]] = $fieldArray[2];
        }
        $body =  str_replace("\r", '', trim($this->rawData[2]));
        $this->data['body'] = $body;
    }

    protected function processFields()
    {
        foreach ($this->data as $field => $value)
        {
            $class = 'TechnoStupid\\Press\\Fields\\' . ucfirst($field);
            if(!class_exists($class) && !method_exists($class, 'process'))
            {
                $class = 'TechnoStupid\\Press\\Fields\\Extra';
            }
            $this->data = array_merge(
                $this->data,
                $class::process($field,$value,$this->data)
            );
        }
    }
}