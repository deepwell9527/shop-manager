<?php

namespace Deepwell\ChannelsShop\Api\Order\Dto;

use Deepwell\Data\Data;

class AfterSaleOrder extends Data
{
    /**
     * 售后单ID
     */
    public int $aftersale_order_id;

    /**
     * 售后单状态
     * @deprecated 售后信息请调用售后接口
     */
    public int $status;
}