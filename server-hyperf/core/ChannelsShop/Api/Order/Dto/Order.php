<?php
declare(strict_types=1);

namespace Deepwell\ChannelsShop\Api\Order\Dto;

use Carbon\Carbon;
use Deepwell\ChannelsShop\Api\Order\Enums\OrderStatus;
use Deepwell\Data\Data;

class Order extends Data
{
    /**
     * 秒级时间戳，订单创建时间
     */
    public Carbon $create_time;

    /**
     * 秒级时间戳，订单更新时间
     */
    public Carbon $update_time;

    /**
     * 订单ID
     */
    public string $order_id;

    /**
     * 订单状态
     */
    public OrderStatus $status;

    /**
     * 买家身份标识
     */
    public string $openid;

    /**
     * 买家在开放平台的唯一标识符，若当前视频号小店已绑定到微信开放平台账号下，绑定成功后产生的订单会返回，详见UnionID 机制说明
     */
    public string $unionid;

    /**
     * 订单详细数据信息
     */
    public OrderDetail $order_detail;

    /**
     * 售后信息
     */
    public AfterSaleDetail $aftersale_detail;
}