<?php

namespace Deepwell\ChannelsShop\Api\Product\Enums;

/**
 * 枚举类，表示发货方式
 */
enum DeliverMethod: int
{
    /**
     * 快递发货
     */
    case ExpressDelivery = 0;

    /**
     * 无需快递
     */
    case NoExpressDelivery = 1;
}
