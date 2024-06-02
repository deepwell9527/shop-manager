<?php
declare(strict_types=1);

namespace Deepwell\ChannelsShop\Api\Product;

use Deepwell\ChannelsShop\Api\Product\Request\GetProductDetailRequest;
use Deepwell\ChannelsShop\Api\Product\Request\GetProductListRequest;
use Deepwell\ChannelsShop\Api\Product\Response\GetProductDetailResponse;
use Deepwell\ChannelsShop\Api\Product\Response\GetProductListResponse;
use Deepwell\ChannelsShop\Contracts\AbstractApiClient;
use EasyWeChat\Kernel\HttpClient\AccessTokenAwareClient;

class Client extends AbstractApiClient
{
    protected AccessTokenAwareClient $client;

    public function getList(GetProductListRequest $req): GetProductListResponse
    {
        $res = $this->client->postJson('/channels/ec/product/list/get', $req->toArray());
        return GetProductListResponse::from($res);
    }

    public function getDetail(GetProductDetailRequest $req): GetProductDetailResponse
    {
        $res = $this->client->postJson('/channels/ec/product/get', $req->toArray());
        return GetProductDetailResponse::from($res);
    }
}