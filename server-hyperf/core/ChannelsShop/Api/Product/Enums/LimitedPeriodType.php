<?php

namespace Deepwell\ChannelsShop\Api\Product\Enums;

/**
 * 枚举类，表示限购周期类型
 */
enum LimitedPeriodType: int
{
    /**
     * 无限购
     */
    case NoLimit = 0;

    /**
     * 按自然日限购
     */
    case DailyLimit = 1;

    /**
     * 按自然周限购
     */
    case WeeklyLimit = 2;

    /**
     * 按自然月限购
     */
    case MonthlyLimit = 3;
}
