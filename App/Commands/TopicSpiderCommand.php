<?php

namespace App\Commands;
use Telegram\Bot\Commands\Command;
use Predis\Client as Predis;
use App\Spiders\Announcement\BterSpider;
use App\Spiders\Announcement\JubiSpider;
use App\Spiders\NoticeCollector;

class TopicSpiderCommand extends Command
{
    /**
     * @var string Command Name
     */
    protected $name = 'spider';
    /**
     * @var array Command Aliases
     */
    protected $aliases = [];

    /**
     * @var string Command Description
     */
    protected $description = <<<'DESC'
货币市场行情数据（数据来源 via bter.com）
    /spider@ latest - 所有交易平台最新公告
DESC;

    protected $redisHandle;

    protected $collector;

    public function __construct()
    {
        $this->redisHandle = new Predis();
        $this->collector = new NoticeCollector([
            BterSpider::class,
            JubiSpider::class
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function handle($arguments)
    {
        $notices = $this->collector->getAllLatestNotices();

        if ($arguments == 'crontab') {
           $this->crontabCommand($notices);
        } else {
            $this->replyCommand($notices);
        }
    }

    /**
     * 定时任务执行
     * @param $notices
     */
    public function crontabCommand($notices)
    {
        foreach ($notices as $notice) {

            $noticeLink = $notice->getNoticeLink();
            $noticeTitle = $notice->getNoticeTitle();

            if (!$this->redisHandle->hexists('topic', $noticeLink)) {
                $this->getTelegram()->sendMessage([
                    'chat_id' => -227188797,
                    'text'    => $notice->toText(),
                ]);
                $this->redisHandle->hset('topic', $noticeLink, $noticeTitle);
            }
        }
    }

    /**
     * 普通命令触发回复消息
     * @param $notices
     */
    public function replyCommand($notices)
    {
        foreach ($notices as $notice) {

            $this->replyWithMessage([
                'text' => $notice->toText(),
            ]);
        }
    }

}