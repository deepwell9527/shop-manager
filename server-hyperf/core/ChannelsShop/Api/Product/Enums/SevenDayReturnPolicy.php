<?php

namespace Deepwell\ChannelsShop\Api\Product\Enums;

/**
 * 枚举类，表示是否支持七天无理由退货
 */
enum SevenDayReturnPolicy: int
{
    /**
     * 不支持七天无理由退货
     */
    case DoesNotSupport = 0;

    /**
     * 支持七天无理由退货
     */
    case Supports = 1;

    /**
     * 支持七天无理由退货（定制商品除外）
     */
    case SupportsExceptCustomGoods = 2;
}
