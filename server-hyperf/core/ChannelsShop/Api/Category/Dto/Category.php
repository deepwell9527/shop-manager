<?php

namespace Deepwell\ChannelsShop\Api\Category\Dto;

use Deepwell\Data\Data;
use Deepwell\Data\Optional;

class Category extends Data
{
    /**
     * 类目ID
     * @var string
     */
    public string $cat_id;

    /**
     * 类目名称
     * @var string
     */
    public string $name;

    /**
     * 父类目ID
     */
    public string|Optional $f_cat_id;

    /**
     * 类目等级
     */
    public string|Optional $level;
}