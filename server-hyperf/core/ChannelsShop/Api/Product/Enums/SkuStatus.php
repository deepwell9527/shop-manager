<?php

namespace Deepwell\ChannelsShop\Api\Product\Enums;

/**
 * 枚举类，表示SKU状态
 */
enum SkuStatus: int
{
    /**
     * 初始值
     */
    case InitialValue = 0;

    /**
     * 上架
     */
    case OnSale = 5;

    /**
     * 回收站
     */
    case RecycleBin = 6;

    /**
     * 自主下架
     */
    case SelfShelved = 11;

    /**
     * 违规下架/风控系统下架
     */
    case OffSaleForViolation = 13;

    /**
     * 保证金不足下架
     */
    case OffSaleForGuaranteeShortage = 14;

    /**
     * 品牌过期下架
     */
    case OffSaleForBrandExpired = 15;

    /**
     * 商品被封禁
     */
    case Banned = 20;
}
