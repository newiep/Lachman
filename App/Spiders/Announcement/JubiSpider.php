<?php

namespace App\Spiders\Announcement;

use App\Spiders\Notice;

class JubiSpider extends CommonSpider
{
    protected $baseUrl = 'https://www.jubi.com';

    /**
     * 获取公告区域
     * @return \Symfony\Component\DomCrawler\Crawler
     */
    public function noticeBoard()
    {
        $noticeUrl = $this->getCompleteUrl('/gonggao/');

        $noticePage = $this->client->request('GET', $noticeUrl);

        return $noticePage->filter('div.new_list > ul');
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
        $title = '【聚币网】' . trim($noticeDom->text());
        return new Notice($title, $href);
    }
}