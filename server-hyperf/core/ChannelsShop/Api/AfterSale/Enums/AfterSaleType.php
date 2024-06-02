<?php

namespace Deepwell\ChannelsShop\Api\AfterSale\Enums;

/**
 * 枚举类，表示售后类型
 */
enum AfterSaleType: string
{
    /**
     * 退款
     */
    case Refund = 'REFUND';

    /**
     * 退货退款
     */
    case Return = 'RETURN';
}
