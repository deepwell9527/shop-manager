<?php

namespace Deepwell\ChannelsShop\Api\Order\Enums;

/**
 * 订单状态枚举类
 */
enum OrderStatus: int
{
    /**
     * 待付款状态
     */
    case WaitingForPayment = 10;

    /**
     * 待发货状态，包括部分发货
     */
    case WaitingForDelivery = 20;

    /**
     * 部分发货状态
     */
    case PartiallyDelivered = 21;

    /**
     * 待收货状态，包括部分发货
     */
    case WaitingForReceipt = 30;

    /**
     * 完成状态
     */
    case Completed = 100;

    /**
     * 订单取消状态，包括未付款取消和售后取消等
     */
    case Canceled = 250;
}
