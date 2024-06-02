<?php
declare(strict_types=1);

namespace Deepwell\ChannelsShop\Api\Order\Dto;

use Deepwell\ChannelsShop\Api\Order\Enums\StockType;
use Deepwell\Data\Data;
use Deepwell\Data\Optional;

class SkuDeliverInfo extends Data
{
    /**
     * 商品发货类型
     */
    public StockType $stock_type;

    /**
     * 预计发货时间(stock_type=1时返回该字段)
     */
    public int|Optional $predict_delivery_time;
}