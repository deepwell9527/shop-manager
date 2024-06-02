<?php
declare(strict_types=1);

namespace Deepwell\ChannelsShop\Api\Order\Request;

use Deepwell\ChannelsShop\Api\Order\Dto\TimeRange;
use Deepwell\ChannelsShop\Api\Order\Enums\OrderStatus;
use Deepwell\Data\Data;
use Deepwell\Data\Optional;

class GetOrderListRequest extends Data
{
    /**
     * 时间范围至少填一个
     */
    public TimeRange|Optional $create_time_range;

    /**
     * 时间范围至少填一个
     */
    public TimeRange|Optional $update_time_range;

    /**
     * 订单状态，具体枚举值请参考RequestOrderStatus枚举
     */
    public OrderStatus|Optional $status;

    /**
     * 买家身份标识
     */
    public string|Optional $openid;

    /**
     * 分页参数，上一页请求返回
     */
    public string|Optional $next_key;

    /**
     * 每页数量(不超过100)
     */
    public int $page_size = 10;
}