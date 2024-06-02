<?php
declare(strict_types=1);

namespace Deepwell\ChannelsShop\Api\Order\Response;

use Deepwell\ChannelsShop\Api\Order\Dto\Order;
use Deepwell\ChannelsShop\Contracts\AbstractResponse;

class GetOrderDetailResponse extends AbstractResponse
{
    public Order $order;
}