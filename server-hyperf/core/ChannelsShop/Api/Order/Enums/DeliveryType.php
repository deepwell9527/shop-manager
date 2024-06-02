<?php

namespace Deepwell\ChannelsShop\Api\Order\Enums;

/**
 * 配送方式枚举
 */
enum DeliveryType: int
{
    /**
     * 自寄快递
     */
    case SelfPostedCourier = 1;

    /**
     * 在线签约快递单
     */
    case OnlineContractedExpress = 2;

    /**
     * 虚拟商品无需物流发货
     */
    case VirtualGoodsNoLogistics = 3;

    /**
     * 在线快递散单
     */
    case OnlineExpressIndividualOrder = 4;
}
