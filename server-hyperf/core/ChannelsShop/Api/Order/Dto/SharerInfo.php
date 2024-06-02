<?php

namespace Deepwell\ChannelsShop\Api\Order\Dto;

use Deepwell\ChannelsShop\Api\Order\Enums\ShareScene;
use Deepwell\ChannelsShop\Api\Sharer\Enums\SharerType;
use Deepwell\Data\Data;

class SharerInfo extends Data
{
    /**
     * 分享员openid
     * @var string
     */
    public string $sharer_openid;

    /**
     * 分享员unionid
     * @var string
     */
    public string $sharer_unionid;

    /**
     * 分享员类型，0：普通分享员，1：店铺分享员
     */
    public SharerType $sharer_type;

    /**
     * 分享场景
     */
    public ShareScene $share_scene;
}