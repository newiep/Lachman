<?php
require 'vendor/autoload.php';

use Telegram\Bot\Api;

//putenv('HTTP_PROXY=socks5://127.0.0.1:1080');
//putenv('HTTPS_PROXY=socks5://127.0.0.1:1080');

$telegram = new Api('331184964:AAEE98Fc-7xQQxPHitWMjOlTQ_M8EdGKEaE');

$telegram->addCommands([
    App\Commands\HelpCommand::class,
    App\Commands\MarketCommand::class,
    App\Commands\TopicSpiderCommand::class,
]);

$telegram->commandsHandler(true);
