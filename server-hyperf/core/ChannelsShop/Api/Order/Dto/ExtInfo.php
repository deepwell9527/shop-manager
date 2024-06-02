<?php

namespace Deepwell\ChannelsShop\Api\Order\Dto;

use Deepwell\Data\Data;

/**
 * 额外信息类
 */
class ExtInfo extends Data
{
    /**
     * 用户备注
     * @var string
     */
    public string $customer_notes;

    /**
     * 商家备注
     * @var string
     */
    public string $merchant_notes;

    /**
     * 确认收货时间，包括用户主动确认收货和超时自动确认收货，秒级时间戳
     * @var int
     */
    public int $confirm_receipt_time;
}