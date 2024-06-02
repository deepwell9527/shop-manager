<?php
declare(strict_types=1);

namespace Deepwell\ChannelsShop\Api\AfterSale\Response;

use Deepwell\ChannelsShop\Api\AfterSale\Dto\AfterSaleOrder;
use Deepwell\ChannelsShop\Contracts\AbstractResponse;

class GetAfterSaleDetailResponse extends AbstractResponse
{
    public AfterSaleOrder $after_sale_order;
}