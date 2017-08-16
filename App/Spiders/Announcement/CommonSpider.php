<?php

namespace App\Spiders\Announcement;

use Goutte\Client;

abstract class CommonSpider
{
    protected $baseUrl;

    protected $headers = [];

    public function __construct()
    {
        $this->client = new Client();
        $this->buildHeader();
    }

    //获取通告区域
    abstract public function noticeBoard();

    //获取最新通告
    abstract public function getLatestNotice();

    protected function getBaseUrl()
    {
        return $this->baseUrl;
    }

    protected function getCompleteUrl($path)
    {
        return rtrim($this->getBaseUrl(), '/') . $path;
    }

    private function buildHeader()
    {
        if (!empty($this->headers)) {
            foreach ($this->headers as $name => $val) {
                $this->client->setHeader($name, $val);
            }
        }
    }


}