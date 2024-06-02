<?php

namespace Deepwell\ChannelsShop\Api\AfterSale\Dto;

use Deepwell\Data\Data;

class ReturnInfo extends Data
{
    /**
     * 快递单号
     * @var string
     */
    public string $waybill_id;

    /**
     * 物流公司id
     * @var string
     */
    public string $delivery_id;

    /**
     * 物流公司名称
     * @var string
     */
    public string $delivery_name;
}