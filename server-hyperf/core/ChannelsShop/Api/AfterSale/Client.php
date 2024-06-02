<?php
declare(strict_types=1);

namespace Deepwell\ChannelsShop\Api\AfterSale;

use Deepwell\ChannelsShop\Api\AfterSale\Request\GetAfterSaleDetailRequest;
use Deepwell\ChannelsShop\Api\AfterSale\Request\GetAfterSaleListRequest;
use Deepwell\ChannelsShop\Api\AfterSale\Response\GetAfterSaleDetailResponse;
use Deepwell\ChannelsShop\Api\AfterSale\Response\GetAfterSaleListResponse;
use Deepwell\ChannelsShop\Contracts\AbstractApiClient;
use EasyWeChat\Kernel\HttpClient\AccessTokenAwareClient;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class Client extends AbstractApiClient
{
    protected AccessTokenAwareClient $client;

    /**
     * 获取视频号小店的售后单列表
     * @param GetAfterSaleListRequest $req
     * @return GetAfterSaleListResponse
     * @throws TransportExceptionInterface
     */
    public function getList(GetAfterSaleListRequest $req): GetAfterSaleListResponse
    {
        $res = $this->client->postJson('/channels/ec//aftersale/getaftersalelist', $req->toArray());
        return GetAfterSaleListResponse::from($res);
    }

    /**
     * 获取订单的详细信息
     * @param GetAfterSaleDetailRequest $req
     * @return GetAfterSaleDetailResponse
     * @throws TransportExceptionInterface
     */
    public function getDetail(GetAfterSaleDetailRequest $req): GetAfterSaleDetailResponse
    {
        $res = $this->client->postJson('/channels/ec/aftersale/getaftersaleorder', $req->toArray());
        return GetAfterSaleDetailResponse::from($res);
    }
}