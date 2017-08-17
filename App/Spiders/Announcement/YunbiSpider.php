<?php

namespace App\Spiders\Announcement;

use App\Spiders\Notice;

class YunbiSpider extends CommonSpider
{
    protected $baseUrl = 'https://yunbi.zendesk.com';

    /**
     * 获取公告区域
     * @return \Symfony\Component\DomCrawler\Crawler
     */
    public function noticeBoard()
    {
        $noticeUrl = $this->getCompleteUrl('/hc/zh-cn/categories/115000844508-%E5%85%AC%E5%91%8A%E6%9D%BF');

        $noticePage = $this->client->request('GET', $noticeUrl);

        return $noticePage->filter('section.section')->first();
    }

    /**
     * 获取最新公告
     * @return Notice
     */
    public function getLatestNotice()
    {
        $crawler = $this->noticeBoard();

        $noticeDom = $crawler->filter('ul.article-list > li > a')->eq(1); //第二个

        $href = $this->getCompleteUrl($noticeDom->attr('href'));
        $title = '【云币网】' . trim($noticeDom->text());
        return new Notice($title, $href);
    }
}