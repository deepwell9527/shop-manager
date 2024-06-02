<?php

namespace Deepwell\ChannelsShop\Api\Product\Dto;

use Deepwell\Data\Data;
use Deepwell\Data\Optional;

class ExpressInfo extends Data
{
    /**
     * 运费模板ID
     */
    public string|Optional $template_id;

    /**
     * 商品重量，单位克
     */
    public int $weight;
}