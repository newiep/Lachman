<?php

namespace App\Spiders\Announcement;

use App\Spiders\Notice;

class Btc9Spider extends CommonSpider
{
    protected $baseUrl = 'https://www.btc9.com';

    //自定义 header 头
    protected $headers = [];

    /**
     * 获取公告区域
     * @return \Symfony\Component\DomCrawler\Crawler
     */
    public function noticeBoard()
    {
        $noticeUrl = $this->getCompleteUrl('/Art/index/id/1.html');

        $noticePage = $this->client->request('GET', $noticeUrl);

        return $noticePage->filter('div.article-main > ul');
    }

    /**
     * 获取最新公告
     * @return Notice
     */
    public function getLatestNotice()
    {
        $crawler = $this->noticeBoard();

        $noticeDom = $crawler->filter('li > a')->first();

        $href = $this->getCompleteUrl($noticeDom->attr('href'));
        $title = '【币久网】' . trim($noticeDom->text());
        return new Notice($title, $href);
    }
}