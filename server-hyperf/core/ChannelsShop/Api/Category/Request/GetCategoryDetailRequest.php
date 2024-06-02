<?php
declare(strict_types=1);

namespace Deepwell\ChannelsShop\Api\Category\Request;

use Deepwell\Data\Data;

class GetCategoryDetailRequest extends Data
{
    /**
     * 三级类目ID
     * @var string
     */
    public string $cat_id;
}