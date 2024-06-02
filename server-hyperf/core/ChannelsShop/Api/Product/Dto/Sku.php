<?php

namespace Deepwell\ChannelsShop\Api\Product\Dto;

use Deepwell\ChannelsShop\Api\Product\Enums\SkuStatus;
use Deepwell\Data\Data;
use Deepwell\Data\Optional;
use Hyperf\Collection\Collection;

class Sku extends Data
{
    /**
     * SKU ID
     * @var string
     */
    public string $sku_id;

    /**
     * 商家自定义SKU ID
     */
    public string|Optional $out_sku_id;

    /**
     * SKU小图
     */
    public string|Optional $thumb_img;

    /**
     * 售卖价格，以分为单位
     * @var int
     */
    public int $sale_price;

    /**
     * SKU库存
     * @var int
     */
    public int $stock_num;

    /**
     * SKU编码
     */
    public string|Optional $sku_code;

    /**
     * SKU属性数组
     * @var Collection<int,SkuAttr>
     */
    public Collection $sku_attrs;

    /**
     * SKU状态
     */
    public SkuStatus $status;

    /**
     * SKU发货信息
     */
    public SkuDeliverInfo $sku_deliver_info;
}