<?php

namespace App\Spiders\Announcement;

use App\Spiders\Notice;

class BterSpider extends CommonSpider
{
    protected $baseUrl = 'https://bter.com';

    //自定义 header 头
    protected $headers = [
        'Cookie' => 'lang=cn',
    ];

    /**
     * 获取公告区域
     * @return \Symfony\Component\DomCrawler\Crawler
     */
    public function noticeBoard()
    {
        $noticeUrl = $this->getCompleteUrl('/articlelist/ann');

        $noticePage = $this->client->request('GET', $noticeUrl);

        return $noticePage->filter('div#lcontentnews > div');
    }

    /**
     * 获取最新公告
     * @return Notice
     */
    public function getLatestNotice()
    {
        $crawler = $this->noticeBoard();

        $noticeDom = $crawler->filter('a')->first();

        $href = $this->getCompleteUrl($noticeDom->attr('href'));
        $title = '【比特儿】' . trim($noticeDom->text());
        return new Notice($title, $href);
    }
}