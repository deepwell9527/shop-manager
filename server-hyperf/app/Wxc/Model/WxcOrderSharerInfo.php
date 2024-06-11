<?php

declare(strict_types=1);

namespace App\Wxc\Model;

use Carbon\Carbon;
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
 * @property int $status 分账状态。0：未结算；1：已结算
 * @property int $amount 分账金额，单位分
 * @property array $rate_rules 分佣比例信息缓存
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class WxcOrderSharerInfo extends MineModel
{
    protected string $primaryKey = 'order_id';

    /**
     * The table associated with the model.
     */
    protected ?string $table = 'wxc_order_sharer_info';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = ['order_id', 'site_id', 'app_id', 'sharer_openid', 'sharer_unionid', 'sharer_type', 'share_scene', 'sku_id', 'from_wecom', 'status', 'amount', 'rate_rules', 'created_at', 'updated_at'];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['order_id' => 'integer', 'site_id' => 'integer', 'sharer_type' => 'integer', 'share_scene' => 'integer', 'sku_id' => 'integer', 'status' => 'integer', 'amount' => 'integer', 'rate_rules' => 'array', 'created_at' => 'datetime', 'updated_at' => 'datetime'];

    protected array $attributes = [
        'rate_rules' => '',
    ];
}
