<?php

namespace Deepwell\ChannelsShop\Api\Product\Dto;

use Deepwell\Data\Data;

class ProductQualityInfo extends Data
{
    /**
     * 商品资质id
     * @var string
     */
    public string $qua_id;

    /**
     * 商品资质图片列表
     * @var string[] 数组
     */
    public array $qua_url;
}