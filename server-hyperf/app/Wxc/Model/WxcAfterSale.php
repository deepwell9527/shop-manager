<?php

declare(strict_types=1);

namespace App\Wxc\Model;

use Carbon\Carbon;
use Mine\MineModel;

/**
 * @property int $after_sale_order_id 售后单号
 * @property int $site_id 租户ID
 * @property string $app_id 视频号小店ID
 * @property string $status 售后单当前状态
 * @property string $openid 买家身份标识
 * @property string $unionid 买家在开放平台的唯一标识符
 * @property array $product_info 售后相关商品信息
 * @property array $details 售后详情
 * @property array $refund_info 退款详情
 * @property array $return_info 用户退货信息
 * @property array $merchant_upload_info 商家上传的信息
 * @property string $reason 退款原因
 * @property string $reason_text 退款原因解释
 * @property string $type 售后类型
 * @property int $complaint_id 纠纷id
 * @property int $order_id 订单号
 * @property array $refund_resp 微信支付退款的响应
 * @property int $deadline 操作剩余时间（秒数）
 * @property Carbon $created_at 售后单创建时间戳
 * @property Carbon $updated_at 售后单更新时间戳
 */
class WxcAfterSale extends MineModel
{
    public bool $incrementing = false;
    protected string $primaryKey = 'after_sale_order_id';
    /**
     * The table associated with the model.
     */
    protected ?string $table = 'wxc_after_sale';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = ['after_sale_order_id', 'site_id', 'app_id', 'status', 'openid', 'unionid', 'product_info', 'details', 'refund_info', 'return_info', 'merchant_upload_info', 'reason', 'reason_text', 'type', 'complaint_id', 'order_id', 'refund_resp', 'deadline', 'created_at', 'updated_at'];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['after_sale_order_id' => 'integer', 'site_id' => 'integer', 'complaint_id' => 'integer', 'order_id' => 'integer', 'deadline' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime',
        'product_info' => 'array',
        'details' => 'array',
        'refund_info' => 'array',
        'return_info' => 'array',
        'merchant_upload_info' => 'array',
        'refund_resp' => 'array',
    ];

    protected array $attributes = [
        'product_info' => '',
        'details' => '',
        'refund_info' => '',
        'return_info' => '',
        'merchant_upload_info' => '',
        'refund_resp' => '',
    ];
}
