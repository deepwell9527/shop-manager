<?php

namespace Deepwell\ChannelsShop\Api\Order\Dto;

use Deepwell\Data\Data;

class DeliveryInfo extends Data
{
    /**
     * 地址信息
     */
    public AddressInfo $address_info;

    /**
     * 发货物流信息，具体结构请参考DeliveryProductInfo结构体
     * @var DeliveryProductInfo[]
     */
    public array $delivery_product_info;

    /**
     * 发货完成时间，秒级时间戳
     * @var int
     */
    public int $ship_done_time;

    /**
     * 订单发货方式，0：普通物流，1：虚拟发货，由商品的同名字段决定
     * @var int
     */
    public int $deliver_method;

    /**
     * 用户下单后申请修改收货地址，商家同意后该字段会覆盖订单地址信息
     */
    public AddressInfo $address_under_review;

    /**
     * 修改地址申请时间，秒级时间戳
     * @var int
     */
    public int $address_apply_time;

    /**
     * 电子面单代发时的订单密文
     * @var string
     */
    public string $ewaybill_order_code;

    /**
     * 订单是否需要走新质检流程，1：需要；0：不需要；不传递本字段表示不需要
     * @var int
     */
    public int $quality_inspect_type;

    /**
     * 质检信息，quality_inspect_type为1时返回
     */
    public QualityInspectInfo $quality_inspect_info;
}