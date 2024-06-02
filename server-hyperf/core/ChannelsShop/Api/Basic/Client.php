<?php
declare(strict_types=1);

namespace Deepwell\ChannelsShop\Api\Basic;

use Deepwell\ChannelsShop\Api\Basic\Response\BasicInfoResponse;
use Deepwell\ChannelsShop\Contracts\AbstractApiClient;
use EasyWeChat\Kernel\HttpClient\AccessTokenAwareClient;
use Throwable;

class Client extends AbstractApiClient
{
    protected AccessTokenAwareClient $client;

    /**
     * 获取店铺基本信息
     * @return BasicInfoResponse
     * @throws Throwable
     */
    public function getBasicInfo(): BasicInfoResponse
    {
        $res = $this->client->get('/channels/ec/basics/info/get');
        return BasicInfoResponse::from($res);
    }
}