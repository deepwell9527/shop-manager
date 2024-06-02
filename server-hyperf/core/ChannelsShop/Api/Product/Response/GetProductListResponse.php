<?php
declare(strict_types=1);

namespace Deepwell\ChannelsShop\Api\Product\Response;

use Deepwell\ChannelsShop\Contracts\AbstractResponse;

class GetProductListResponse extends AbstractResponse
{
    /**
     * 商品id列表
     * @var array<string>
     */
    public array $product_ids;

    /**
     * 本次翻页的上下文，用于请求下一页
     * @var string
     */
    public string $next_key;

    /**
     * 商品总数
     * @var int
     */
    public int $total_num;
}