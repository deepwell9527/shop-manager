<?php
declare(strict_types=1);

namespace Deepwell\ChannelsShop\Api\Order\Request;

use Deepwell\Data\Data;

class GetOrderDetailRequest extends Data
{
    /**
     * 订单ID
     */
    public string $order_id;

    /**
     * 用于商家提前测试订单脱敏效果，如果传true，即对订单进行脱敏，后期会默认对所有订单脱敏
     */
    public bool $encode_sensitive_info = false;
}