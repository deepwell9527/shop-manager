<?php

declare(strict_types=1);

namespace App\Wxc\Command;

use App\Wxc\Concern\ManageChannelsShopApp;
use App\Wxc\Model\WxcShop;
use App\Wxc\Model\WxcShopCallback;
use Deepwell\ChannelsShop\Config;
use Hyperf\Command\Annotation\Command;
use Hyperf\Command\Command as HyperfCommand;
use Psr\Container\ContainerInterface;

#[Command]
class WxcCallbackConsumeCommand extends HyperfCommand
{
    use ManageChannelsShopApp;

    public function __construct(protected ContainerInterface $container)
    {
        parent::__construct('wxc:callback:consume');
    }

    public function configure()
    {
        parent::configure();
        $this->setDescription('微信视频号小店回调消息处理');
    }

    public function handle()
    {
        $record = WxcShopCallback::first();
        dump($record->content);
        $appInfo = WxcShop::where('site_id', $record->site_id)->where('app_id', $record->content['get']['app_id'])->first();
        $config = new Config($appInfo->toArray());
        $app = $this->initApplication($config);
        $message = $app->getEncryptor()->decrypt($record->content['post']['Encrypt'], $record->content['get']['msg_signature'], $record->content['get']['nonce'], $record->content['get']['timestamp']);
        dump($message);
    }
}
