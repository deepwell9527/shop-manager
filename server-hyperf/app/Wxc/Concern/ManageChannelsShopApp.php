<?php

namespace App\Wxc\Concern;

use App\Wxc\Service\WxcShopService;
use Deepwell\ChannelsShop\Application;
use Deepwell\ChannelsShop\Config;
use Exception;
use Psr\SimpleCache\CacheInterface;

trait ManageChannelsShopApp
{
    public function initApplicationByAppId(string $appId)
    {
        $shopServ = container()->get(WxcShopService::class);
        $shopConf = $shopServ->findByAppId($appId);
        if (!$shopConf) {
            throw new Exception('小店配置信息不存在');
        }
        $config = new Config($shopConf->toArray());
        return $this->initApplication($config);
    }

    public function initApplication(Config $config)
    {
        //$app = make(Application::class, [[]]);
        $app  = container()->get(Application::class);
        $cache = container()->get(CacheInterface::class);
        $app->setCache($cache);
        $app->setConfig($config);
        return $app;
    }
}