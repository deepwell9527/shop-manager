<?php
declare(strict_types=1);

namespace Deepwell\ChannelsShop\Api\Basic\Response;

use Deepwell\ChannelsShop\Api\Basic\Dto\BasicInfo;
use Deepwell\ChannelsShop\Contracts\AbstractResponse;

class BasicInfoResponse extends AbstractResponse
{
    /**
     * 店铺基本信息
     */
    public BasicInfo $info;
}