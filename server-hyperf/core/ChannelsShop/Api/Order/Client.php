<?php
declare(strict_types=1);

namespace Deepwell\ChannelsShop\Api\Order;

use Deepwell\ChannelsShop\Api\Order\Request\GetOrderDetailRequest;
use Deepwell\ChannelsShop\Api\Order\Request\GetOrderListRequest;
use Deepwell\ChannelsShop\Api\Order\Response\GetOrderDetailResponse;
use Deepwell\ChannelsShop\Api\Order\Response\GetOrderListResponse;
use Deepwell\ChannelsShop\Contracts\AbstractApiClient;
use EasyWeChat\Kernel\HttpClient\AccessTokenAwareClient;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class Client extends AbstractApiClient
{
    protected AccessTokenAwareClient $client;

    /**
     * 获取视频号小店的订单列表
     * @param GetOrderListRequest $req
     * @return GetOrderListResponse
     * @throws TransportExceptionInterface
     */
    public function getList(GetOrderListRequest $req): GetOrderListResponse
    {
        $res = $this->client->postJson('/channels/ec/order/list/get', $req->toArray());
        return GetOrderListResponse::from($res);
    }

    /**
     * 获取订单的详细信息
     * @param GetOrderDetailRequest $req
     * @return GetOrderDetailResponse
     * @throws TransportExceptionInterface
     */
    public function getDetail(GetOrderDetailRequest $req): GetOrderDetailResponse
    {
        $res = $this->client->postJson('/channels/ec/order/get', $req->toArray());
        return GetOrderDetailResponse::from($res);
    }
}