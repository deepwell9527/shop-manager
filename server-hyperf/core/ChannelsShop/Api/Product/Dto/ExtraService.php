<?php

namespace Deepwell\ChannelsShop\Api\Product\Dto;

use Deepwell\ChannelsShop\Api\Product\Enums\SevenDayReturnPolicy;
use Deepwell\Data\Data;

class ExtraService extends Data
{
    /**
     * 是否支持七天无理由退货
     */
    public SevenDayReturnPolicy $seven_day_return;

    /**
     * 先用后付服务,0-不支持先用后付，1-支持先用后付
     * @var int
     */
    public int $pay_after_use;

    /**
     * 运费险服务,0-不支持运费险，1-支持运费险
     * @var int
     */
    public int $freight_insurance;
}