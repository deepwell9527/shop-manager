<?php

namespace Deepwell\ChannelsShop\Api\Category\Dto;

use Deepwell\Data\Data;
use Hyperf\Collection\Collection;

class CategoryInfoSet extends Data
{
    /**
     * @var Collection<int,CatAndQua>
     */
    public Collection $cat_and_qua;
}