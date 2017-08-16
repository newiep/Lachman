<?php

namespace App\Spiders;

class Notice
{

    protected $title;

    protected $href;

    public function __construct($title, $href)
    {
        $this->title = $title;
        $this->href = $href;
    }

    public function toText()
    {
        return $this->title . PHP_EOL . $this->href;
    }

    public function getNoticeLink()
    {
        return $this->href;
    }

    public function getNoticeTitle()
    {
        return $this->title;
    }
}