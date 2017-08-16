<?php

namespace App\Commands;
use Telegram\Bot\Commands\Command;

class MarketCommand extends Command
{

    /**
     * 交易市场详细行情 API
     */
    const MARKET_LIST_API = 'http://data.bter.com/api2/1/marketlist';

    /**
     * @var string Command Name
     */
    protected $name = 'market';
    /**
     * @var array Command Aliases
     */
    protected $aliases = [];
    /**
     * @var string Command Description
     */
    protected $description = <<<'DESC'
货币市场行情数据（数据来源 via bter.com）
    /market@ list - 所有货币行情数据列表
DESC;


    /**
     * {@inheritdoc}
     */
    public function handle($arguments)
    {
        $subCommand = "{$arguments}SubCommand";

        if (empty($arguments) || !method_exists($this, $subCommand)) {
            $response['text'] = $this->getDescription();
        } else {
            $response = call_user_func([$this, $subCommand]);
        }
        $this->replyWithMessage($response);
    }

    public function listSubCommand()
    {
        $monitorCoins = ['BTM', 'ETH', 'BTC', 'BCC', 'ETC', 'LTC', 'QTUM', 'EOS', 'BAT', 'OMG',];
        $hadRecord = [];
        $listTitle = '币种（代号） | 价格（CNY） | 日涨跌 | 交易量 | 总市值（CNY）';
        $listBody = '';

        $response = json_decode(file_get_contents(self::MARKET_LIST_API), true);
        foreach ($response['data'] as $coinItem) {
            if (
                !in_array($coinItem['symbol'], $monitorCoins) ||
                in_array($coinItem['symbol'], $hadRecord)
            ) {
                continue;
            }

            $listBody .= sprintf(
                '%s | %s | %s | %s | %s' .  PHP_EOL . PHP_EOL,
                $coinItem['name_cn'] . "({$coinItem['symbol']})",
                $coinItem['rate'],
                $coinItem['rate_percent'] . "%",
                $coinItem['vol_b'],
                $coinItem['marketcap']
            );
            $hadRecord[] = $coinItem['symbol'];
        }

        return ['text' => $listTitle . PHP_EOL . $listBody];
    }
}