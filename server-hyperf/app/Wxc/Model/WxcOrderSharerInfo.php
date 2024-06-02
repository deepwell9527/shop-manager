<?php

declare(strict_types=1);

namespace App\Wxc\Model;

use Mine\MineModel;

/**
 * @property int $order_id 订单ID
 * @property int $site_id 租户ID
 * @property string $app_id 视频号小店ID
 * @property string $sharer_openid 分享员openid
 * @property string $sharer_unionid 分享员unionid
 * @property int $sharer_type 分享员类型，0：普通分享员，1：店铺分享员
 * @property int $share_scene 分享场景，1：直播间，2：橱窗，3：短视频，4：视频号主页，5：商品详情页，6：带商品的公众号文章
 * @property int $sku_id 商品skuid
 * @property string $from_wecom 是否来自企微分享
 */
class WxcOrderSharerInfo extends MineModel
{
    protected string $primaryKey = 'order_id';
    public bool $timestamps = false;
    /**
     * The table associated with the model.
     */
    protected ?string $table = 'wxc_order_sharer_info';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = ['order_id', 'site_id', 'app_id', 'sharer_openid', 'sharer_unionid', 'sharer_type', 'share_scene', 'sku_id', 'from_wecom'];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['order_id' => 'integer', 'site_id' => 'integer', 'sharer_type' => 'integer', 'share_scene' => 'integer', 'sku_id' => 'integer'];
}
