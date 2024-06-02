<?php

namespace Deepwell\ChannelsShop\Api\Product\Dto;

use Deepwell\ChannelsShop\Api\Product\Enums\StockType;
use Deepwell\Data\Data;

class SkuDeliverInfo extends Data
{
    /**
     * SKU库存情况
     * 0:现货（默认），1:全款预售
     */
    public StockType $stock_type;

    /**
     * SKU发货节点，该字段仅对stock_type=1有效。
     * 0:付款后n天发货，1:预售结束后n天发货
     * @var int
     */
    public int $full_payment_presale_delivery_type;

    /**
     * SKU预售周期开始时间，秒级时间戳，该字段仅对delivery_type=1有效。
     * @var int
     */
    public int $presale_begin_time;

    /**
     * SKU预售周期结束时间，秒级时间戳，该字段仅对delivery_type=1有效。
     * @var int
     */
    public int $presale_end_time;

    /**
     * SKU发货时效，即付款后/预售结束后{full_payment_presale_delivery_time}天内发货，该字段仅对stock_type=1时有效。
     * @var int
     */
    public int $full_payment_presale_delivery_time;
}