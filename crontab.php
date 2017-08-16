<?php
require 'vendor/autoload.php';

use Telegram\Bot\Api;

//putenv('HTTP_PROXY=socks5://127.0.0.1:1080');
//putenv('HTTPS_PROXY=socks5://127.0.0.1:1080');

//$telegram = new Api('331184964:AAEE98Fc-7xQQxPHitWMjOlTQ_M8EdGKEaE');
//
//$telegram->addCommands([
//    App\Commands\TopicSpiderCommand::class,
//]);
//
//$telegram->getCommandBus()->execute('spider', 'crontab', '');


$jubi = new \App\Spiders\Announcement\JubiSpider();
dd($jubi->getLatestNotice());