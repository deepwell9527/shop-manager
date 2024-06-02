<?php
declare(strict_types=1);

namespace Deepwell\ChannelsShop\Api\AfterSale\Request;

use Carbon\Carbon;
use Deepwell\Data\Data;

class GetAfterSaleListRequest extends Data
{
    /**
     * 订单创建启始时间
     * @var Carbon
     */
    public Carbon $begin_create_time;

    /**
     * 订单创建结束时间，end_create_time减去begin_create_time不得大于24小时
     * @var Carbon
     */
    public Carbon $end_create_time;

    /**
     * 翻页参数，从第二页开始传，来源于上一页的返回值
     * @var string
     */
    public string $next_key = '';
}