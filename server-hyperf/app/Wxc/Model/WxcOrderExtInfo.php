<?php

declare(strict_types=1);

namespace App\Wxc\Model;

use Carbon\Carbon;
use Mine\MineModel;

/**
 * @property int $order_id 订单ID
 * @property int $site_id 租户ID
 * @property string $app_id 视频号小店ID
 * @property string $customer_notes 用户备注
 * @property string $merchant_notes 商家备注
 * @property int $confirm_receipt_time 确认收货时间，包括用户主动确认收货和超时自动确认收货
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class WxcOrderExtInfo extends MineModel
{
    protected string $primaryKey = 'order_id';
    /**
     * The table associated with the model.
     */
    protected ?string $table = 'wxc_order_ext_info';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = ['order_id', 'site_id', 'app_id', 'customer_notes', 'merchant_notes', 'confirm_receipt_time', 'created_at', 'updated_at'];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['order_id' => 'integer', 'site_id' => 'integer', 'confirm_receipt_time' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}
