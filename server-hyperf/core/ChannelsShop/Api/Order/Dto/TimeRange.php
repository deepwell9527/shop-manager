<?php

namespace Deepwell\ChannelsShop\Api\Order\Dto;

use Deepwell\Data\Data;

class TimeRange extends Data
{
    /**
     * 距离end_time不可超过7天
     */
    public int $start_time;

    /**
     * 距离start_time不可超过7天
     */
    public int $end_time;
}