<?php

namespace Deepwell\ChannelsShop\Api\Order\Dto;

use Deepwell\Data\Data;

class TelNumberExtInfo extends Data
{
    /**
     * 脱敏手机号
     * @var string
     */
    public string $real_tel_number;

    /**
     * 完整的虚拟号码
     * @var string
     */
    public string $virtual_tel_number;

    /**
     * 主动兑换的虚拟号码过期时间，秒级时间戳
     * @var int
     */
    public int $virtual_tel_expire_time;

    /**
     * 主动兑换虚拟号码次数
     * @var int
     */
    public int $get_virtual_tel_cnt;
}