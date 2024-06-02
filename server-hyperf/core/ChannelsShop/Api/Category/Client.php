<?php
declare(strict_types=1);

namespace Deepwell\ChannelsShop\Api\Category;

use Deepwell\ChannelsShop\Api\Category\Request\GetCategoryDetailRequest;
use Deepwell\ChannelsShop\Api\Category\Response\GetCategoryAllResponse;
use Deepwell\ChannelsShop\Api\Category\Response\GetCategoryDetailResponse;
use Deepwell\ChannelsShop\Contracts\AbstractApiClient;
use EasyWeChat\Kernel\HttpClient\AccessTokenAwareClient;

class Client extends AbstractApiClient
{
    protected AccessTokenAwareClient $client;

    public function getAll(): GetCategoryAllResponse
    {
        $res = $this->client->get('/channels/ec/category/all');
        return GetCategoryAllResponse::from($res);
    }

    public function getDetail(GetCategoryDetailRequest $req): GetCategoryDetailResponse
    {
        $res = $this->client->postJson('/channels/ec/category/detail', $req->toArray());
        return GetCategoryDetailResponse::from($res);
    }
}