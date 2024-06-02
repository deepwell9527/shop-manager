<?php
declare(strict_types=1);

namespace Deepwell\ChannelsShop\Api\Product\Response;

use Deepwell\ChannelsShop\Api\Product\Dto\Product;
use Deepwell\ChannelsShop\Contracts\AbstractResponse;
use Deepwell\Data\Optional;

class GetProductDetailResponse extends AbstractResponse
{
    /**
     * 商品线上数据，入参data_type==2时不返回该字段；入参data_type==3且商品从未上架过，不返回该字段
     */
    public Product|Optional $product;

    /**
     * 商品草稿数据，入参data_type==1时不返回该字段
     */
    public Product|Optional $edit_product;
}