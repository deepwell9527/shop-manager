<?php

namespace Deepwell\ChannelsShop\Api\Product\Enums;

/**
 * 枚举类，表示商品类型
 */
enum ProductType: int
{
    /**
     * 小店普通自营商品
     */
    case OrdinarySelfOperatedProduct = 1;

    /**
     * 福袋抽奖商品
     * 福袋抽奖、直播间闪电购类型的商品为只读数据，不支持编辑、上架操作，
     * 不支持用data_type=2的参数获取
     */
    case LuckyBagProduct = 2;

    /**
     * 直播间闪电购商品
     * 福袋抽奖、直播间闪电购类型的商品为只读数据，不支持编辑、上架操作，
     * 不支持用data_type=2的参数获取
     */
    case LiveStreamFlashPurchaseProduct = 3;
}
