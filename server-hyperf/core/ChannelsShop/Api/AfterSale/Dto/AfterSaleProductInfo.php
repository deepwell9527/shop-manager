<?php

namespace Deepwell\ChannelsShop\Api\AfterSale\Dto;

use Deepwell\Data\Data;

class AfterSaleProductInfo extends Data
{
    /**
     * 商品spuid
     * @var string
     */
    public string $product_id;

    /**
     * 商品skuid
     * @var string
     */
    public string $sku_id;

    /**
     * 售后数量
     * @var int
     */
    public int $count;

    /**
     * 是否极速退款
     * @var bool
     */
    public bool $fast_refund;
}