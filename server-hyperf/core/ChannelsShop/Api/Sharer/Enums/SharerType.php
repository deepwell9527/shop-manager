<?php
declare(strict_types=1);

namespace Deepwell\ChannelsShop\Api\Sharer\Enums;
/**
 * 分享员类型
 */
enum SharerType: int
{
    /**
     * 普通分享员
     */
    case Normal = 0;

    /**
     * 店铺分享员
     */
    case Shop = 1;
}
