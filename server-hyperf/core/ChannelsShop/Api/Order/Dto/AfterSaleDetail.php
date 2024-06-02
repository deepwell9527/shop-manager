<?php

namespace Deepwell\ChannelsShop\Api\Order\Dto;

use Deepwell\Data\Data;

class AfterSaleDetail extends Data
{
    /**
     * 正在售后流程的售后单数
     */
    public int $on_aftersale_order_cnt;

    /**
     * 售后单列表
     * @var array<AfterSaleOrder>
     */
    public array $aftersale_order_list;
}