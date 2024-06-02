<?php

namespace Deepwell\ChannelsShop\Api\Order\Enums;

/**
 * 分享场景枚举
 */
enum ShareScene: int
{
    /**
     * 直播间
     */
    case LiveRoom = 1;

    /**
     * 橱窗
     */
    case Showcase = 2;

    /**
     * 短视频
     */
    case ShortVideo = 3;

    /**
     * 视频号主页
     */
    case VideoProfile = 4;

    /**
     * 商品详情页
     */
    case ProductDetail = 5;

    /**
     * 带商品的公众号文章
     */
    case WeChatArticleWithProduct = 6;
}