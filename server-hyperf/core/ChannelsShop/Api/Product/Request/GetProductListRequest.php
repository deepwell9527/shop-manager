<?php
declare(strict_types=1);

namespace Deepwell\ChannelsShop\Api\Product\Request;

use Deepwell\ChannelsShop\Api\Product\Enums\SkuStatus;
use Deepwell\Data\Data;
use Deepwell\Data\Optional;

class GetProductListRequest extends Data
{
    /**
     * 商品状态，不填默认拉全部商品（不包含回收站）
     * 可选值：0,5,6,11（11包括11,13,14,15,20）
     */
    public SkuStatus|Optional $status;


    /**
     * 由上次请求返回，记录翻页的上下文。传入时会从上次返回的结果往后翻一页，不传默认获取第一页数据
     */
    public string|Optional $next_key;

    /**
     * 每页数量（默认10，不超过30）
     */
    public int $page_size = 10;
}