<?php

namespace Deepwell\ChannelsShop\Api\Product\Dto;

use Deepwell\ChannelsShop\Api\Product\Enums\LimitedPeriodType;
use Deepwell\Data\Data;

class LimitedInfo extends Data
{
    /**
     * 限购周期类型
     */
    public LimitedPeriodType $period_type;

    /**
     * 限购数量
     * @var int
     */
    public int $limited_buy_num;
}