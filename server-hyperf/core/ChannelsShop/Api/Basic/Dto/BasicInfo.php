<?php
declare(strict_types=1);

namespace Deepwell\ChannelsShop\Api\Basic\Dto;

use Deepwell\ChannelsShop\Api\Basic\Enums\ShopStatus;
use Deepwell\ChannelsShop\Api\Basic\Enums\ShopSubjectType;
use Deepwell\Data\Data;

class BasicInfo extends Data
{
    /**
     * 店铺名称
     */
    public string $nickname;

    /**
     * 店铺头像URL
     */
    public string $headimg_url;

    /**
     * 店铺类型
     */
    public ShopSubjectType $subject_type;

    /**
     * 店铺状态
     */
    public ShopStatus $status;

    /**
     * 店铺原始ID
     */
    public string $username;
}