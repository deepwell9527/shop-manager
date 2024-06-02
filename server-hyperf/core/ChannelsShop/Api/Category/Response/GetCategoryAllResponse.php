<?php
declare(strict_types=1);

namespace Deepwell\ChannelsShop\Api\Category\Response;

use Deepwell\ChannelsShop\Api\Category\Dto\CategoryInfoSet;
use Deepwell\ChannelsShop\Contracts\AbstractResponse;
use Hyperf\Collection\Collection;

class GetCategoryAllResponse extends AbstractResponse
{
    /**
     * 类目信息集合列表
     * @var Collection<int,CategoryInfoSet>
     */
    public Collection $cats;
}