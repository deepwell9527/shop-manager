<?php

namespace Deepwell\ChannelsShop\Api\Order\Dto;

use Deepwell\Data\Data;

class FreightProductInfo extends Data
{
    /**
     * 商品id
     * @var string
     */
    public string $product_id;

    /**
     * sku_id
     * @var string
     */
    public string $sku_id;

    /**
     * 商品数量
     * @var int
     */
    public int $product_cnt;
}