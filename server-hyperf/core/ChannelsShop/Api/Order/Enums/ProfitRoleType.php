<?php

namespace Deepwell\ChannelsShop\Api\Order\Enums;

/**
 * 分账方类型枚举
 */
enum ProfitRoleType: int
{
    /**
     * 达人
     */
    case Talent = 0;

    /**
     * 团长
     */
    case TeamLeader = 1;
}