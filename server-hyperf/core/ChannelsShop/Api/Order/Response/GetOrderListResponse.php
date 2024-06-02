<?php
declare(strict_types=1);

namespace Deepwell\ChannelsShop\Api\Order\Response;

use Deepwell\ChannelsShop\Contracts\AbstractResponse;

class GetOrderListResponse extends AbstractResponse
{
    /**
     * 订单号列表
     * @var array<string>
     */
    public array $order_id_list;

    /**
     * 分页参数，下一页请求返回
     */
    public string $next_key;

    /**
     * 是否还有下一页，true:有下一页；false:已经结束，没有下一页
     */
    public bool $has_more;
}