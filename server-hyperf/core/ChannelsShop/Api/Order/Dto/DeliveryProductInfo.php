<?php

namespace Deepwell\ChannelsShop\Api\Order\Dto;

use Deepwell\ChannelsShop\Api\Order\Enums\DeliveryType;
use Deepwell\Data\Data;

class DeliveryProductInfo extends Data
{
    /**
     * 快递单号
     * @var string
     */
    public string $waybill_id;

    /**
     * 快递公司编码
     * @var string
     */
    public string $delivery_id;

    /**
     * 包裹中商品信息
     * @var FreightProductInfo[]
     */
    public array $product_infos;

    /**
     * 快递公司名称
     * @var string
     */
    public string $delivery_name;

    /**
     * 发货时间，秒级时间戳
     * @var int
     */
    public int $delivery_time;

    /**
     * 配送方式
     */
    public DeliveryType $deliver_type;

    /**
     * 发货地址，具体结构请参考AddressInfo结构体
     * @var AddressInfo
     */
    public AddressInfo $delivery_address;
}