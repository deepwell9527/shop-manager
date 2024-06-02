<?php

namespace Deepwell\ChannelsShop\Api\Order\Dto;

use Deepwell\Data\Data;

class ProductExtraService extends Data
{
    /**
     * 7天无理由：0：不支持，1：支持
     */
    public int $seven_day_return;

    /**
     * 商家运费险：0：不支持，1：支持
     */
    public int $freight_insurance;
}