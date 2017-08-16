<?php

namespace App\Spiders\Announcement;

use App\Spiders\Notice;

class BinanceSpider extends CommonSpider
{
    protected $baseUrl = 'https://binance.zendesk.com';

    /**
     * 获取公告区域
     * @return \Symfony\Component\DomCrawler\Crawler
     */
    public function noticeBoard()
    {
        $noticeUrl = $this->getCompleteUrl('/hc/zh-cn/categories/115000056351');

        $noticePage = $this->client->request('GET', $noticeUrl);

        return $noticePage->filter('ul.article-list');
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
        $title = '【币安网】' . trim($noticeDom->text());
        return new Notice($title, $href);
    }
}