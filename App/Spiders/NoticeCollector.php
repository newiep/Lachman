<?php

namespace App\Spiders;

class NoticeCollector
{
    protected $spiderStack = [];
    protected $notices;

    public function __construct($spiders = [])
    {
        $this->fillSpiders($spiders);
    }

    public function fillSpiders($spiders = [])
    {
        foreach ($spiders as $spider) {
            $this->spiderStack[] = new $spider();
        }
    }

    public function getAllLatestNotices()
    {
        $notices = [];
        foreach ($this->spiderStack as $spider) {
            $notices[] = $spider->getLatestNotice();
        }
        return $notices;
    }
}