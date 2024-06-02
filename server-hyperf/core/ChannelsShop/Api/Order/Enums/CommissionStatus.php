<?php

namespace Deepwell\ChannelsShop\Api\Order\Enums;

/**
 * 分账状态枚举
 */
enum CommissionStatus: int
{
    /**
     * 未结算
     */
    case Unsettled = 1;

    /**
     * 已结算
     */
    case Settled = 2;
}
