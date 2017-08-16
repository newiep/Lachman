<?php

namespace App\Spiders\Announcement;

use App\Spiders\Notice;

class SzzcSpider extends CommonSpider
{
    protected $baseUrl = 'https://www.szzc.com';

    protected $headers = [
        'user-agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.90 Safari/537.36',
    ];
    /**
     * 获取公告区域
     * @return \Symfony\Component\DomCrawler\Crawler
     */
    public function noticeBoard()
    {
        $noticeUrl = 'https://szzc.com/api/news/articles/NOTICE?language=zh';

        return json_decode(file_get_contents($noticeUrl), true);
    }

    /**
     * 获取最新公告
     * @return Notice
     */
    public function getLatestNotice()
    {
        $crawler = $this->noticeBoard();

        $noticeDom = $crawler['result']['data'][0];

        $href = $this->getCompleteUrl("/#!/news/{$noticeDom['id']}");
        $title = '【海枫藤】' . trim($noticeDom['subject']);

        return new Notice($title, $href);
    }
}