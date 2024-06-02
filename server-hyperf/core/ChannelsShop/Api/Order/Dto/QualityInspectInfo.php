<?php

namespace Deepwell\ChannelsShop\Api\Order\Dto;

use Deepwell\ChannelsShop\Api\Order\Enums\InspectStatus;
use Deepwell\Data\Data;

class QualityInspectInfo extends Data
{
    /**
     * 质检状态
     */
    public InspectStatus $inspect_status;
}