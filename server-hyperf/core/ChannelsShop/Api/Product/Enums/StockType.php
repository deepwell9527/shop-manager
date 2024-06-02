<?php

namespace Deepwell\ChannelsShop\Api\Product\Enums;

enum StockType: int
{
    /**
     * 现货
     */
    case InStock = 0;

    /**
     * 全款预售
     */
    case PreSale = 1;
}
