<?php

declare(strict_types=1);

namespace Deepwell\ChannelsShop;

use Deepwell\ChannelsShop\Api\Sharer\Client;
use EasyWeChat\Kernel\Config;
use EasyWeChat\Kernel\Contracts\AccessToken as AccessTokenInterface;
use EasyWeChat\Kernel\Contracts\RefreshableAccessToken as RefreshableAccessTokenInterface;
use EasyWeChat\Kernel\Contracts\Server as ServerInterface;

/**
 * 视频号小店
 * @property Client $sharer 分享员接口客户端
 * @property Api\Product\Client $product 商品接口客户端
 * @property Api\Category\Client $category 类目接口客户端
 * @property Api\Basic\Client $basic 基础接口客户端
 * @property Api\Order\Client $order 订单接口客户端
 */
class Application extends \EasyWeChat\OfficialAccount\Application
{
    protected array $apiClassMapping = [
        'basic' => Api\Basic\Client::class,
        'product' => Api\Product\Client::class,
        'category' => Api\Category\Client::class,
        'sharer' => Client::class,
        'order' => Api\Order\Client::class,
    ];

    public function __construct(?Config $config = null)
    {
        if (is_null($config)) {
            $config = [];
        }
        parent::__construct($config);
    }

    public function getServer(): Server|ServerInterface
    {
        $this->server = container()->get(Server::class);

        $this->server->setRequest($this->getRequest());
        $this->server->setEncryptor($this->getEncryptor());

        return $this->server;
    }

    public function getAccessToken(): AccessTokenInterface|RefreshableAccessTokenInterface
    {
        if (!$this->accessToken) {
            $this->accessToken = new AccessToken(
                appId: $this->getAccount()->getAppId(),
                secret: $this->getAccount()->getSecret(),
                cache: $this->getCache(),
                httpClient: $this->getHttpClient(),
                stable: $this->config->get('use_stable_access_token', false),
            );
        }

        return $this->accessToken;
    }

    public function __get(string $name)
    {
        if (isset($this->apiClassMapping[$name])) {
            $class = $this->apiClassMapping[$name];
            $c = container()->get($class);
            return $c->setAccessTokenAwareClient($this->getClient());
        }
        return null;
    }
}
