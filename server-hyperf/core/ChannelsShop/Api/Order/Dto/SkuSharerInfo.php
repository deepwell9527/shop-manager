<?php

namespace Deepwell\ChannelsShop\Api\Order\Dto;

use Deepwell\ChannelsShop\Api\Order\Enums\ShareScene;
use Deepwell\ChannelsShop\Api\Sharer\Enums\SharerType;
use Deepwell\Data\Data;

/**
 * SKU分享员信息类
 */
class SkuSharerInfo extends Data
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

    /**
     * 商品skuid
     * @var string
     */
    public string $sku_id;

    /**
     * 是否来自企微分享
     * @var bool
     */
    public bool $from_wecom;
}