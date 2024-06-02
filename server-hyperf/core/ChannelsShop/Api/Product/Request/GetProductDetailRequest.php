<?php
declare(strict_types=1);

namespace Deepwell\ChannelsShop\Api\Product\Request;

use Deepwell\Data\Data;

class GetProductDetailRequest extends Data
{
    /**
     * 商品ID
     * @var string
     */
    public string $product_id;

    /**
     * 数据类型
     * - 1: 获取线上数据
     * - 2: 获取草稿数据
     * - 3: 同时获取线上和草稿数据（注意：上架过的商品才有线上数据）
     * @var int
     */
    public int $data_type = 1;
}