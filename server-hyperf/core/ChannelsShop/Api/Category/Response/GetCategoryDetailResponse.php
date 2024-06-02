<?php
declare(strict_types=1);

namespace Deepwell\ChannelsShop\Api\Category\Response;

use Deepwell\ChannelsShop\Api\Category\Dto\Category;
use Deepwell\ChannelsShop\Contracts\AbstractResponse;

class GetCategoryDetailResponse extends AbstractResponse
{
    /**
     * 类目信息
     */
    public Category $info;

    // todo 其他的属性暂不需要
}