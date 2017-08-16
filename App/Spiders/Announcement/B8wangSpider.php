<?php

namespace App\Spiders\Announcement;

use App\Spiders\Notice;

class B8wangSpider extends CommonSpider
{
    protected $baseUrl = 'https://www.b8wang.com';

    /**
     * 获取公告区域
     * @return \Symfony\Component\DomCrawler\Crawler
     */
    public function noticeBoard()
    {
        $noticeUrl = $this->getCompleteUrl('/news/');

        $noticePage = $this->client->request('GET', $noticeUrl);

        return $noticePage->filter('div.post');
    }

    /**
     * 获取最新公告
     * @return Notice
     */
    public function getLatestNotice()
    {
        $crawler = $this->noticeBoard();

        $noticeDom = $crawler->filter('div.pull-left > a')->first();

        $href = $this->getCompleteUrl($noticeDom->attr('href'));
        $title = '【B8网】' . trim($noticeDom->text());
        return new Notice($title, $href);
    }
}