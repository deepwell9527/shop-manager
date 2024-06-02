<?php

namespace Deepwell\ChannelsShop\Api\Product\Dto;

use Deepwell\Data\Data;
use Deepwell\Data\Optional;

/**
 * 商品详情信息类
 */
class Desc extends Data
{
    /**
     * 商品详情图片数组
     * @var string[]|Optional
     */
    public array|Optional $imgs;

    /**
     * 商品详情文字
     */
    public string|Optional $desc;
}