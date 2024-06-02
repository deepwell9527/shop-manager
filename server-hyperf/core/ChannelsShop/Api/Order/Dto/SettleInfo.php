<?php

namespace Deepwell\ChannelsShop\Api\Order\Dto;

use Deepwell\Data\Data;
use Deepwell\Data\Optional;

/**
 * 结算信息类
 */
class SettleInfo extends Data
{
    /**
     * 预计技术服务费，单位为分
     * @var int
     */
    public int $predict_commission_fee;

    /**
     * 实际技术服务费，单位为分（未结算时本字段为空）
     */
    public int|Optional $commission_fee;

    /**
     * 预计人气卡返佣金额，单位为分（未发起结算时本字段为空）
     */
    public int|Optional $predict_wecoin_commission;

    /**
     * 实际人气卡返佣金额，单位为分（未结算时本字段为空）
     */
    public int|Optional $wecoin_commission;

    /**
     * 商家结算时间，秒级时间戳
     * @var int
     */
    public int $settle_time;
}