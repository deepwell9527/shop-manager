<?php

declare(strict_types=1);

namespace App\Wxc\Model;

use Carbon\Carbon;
use Mine\MineModel;

/**
 * @property int $order_id 订单ID
 * @property int $site_id 租户ID
 * @property string $app_id 视频号小店ID
 * @property string $address_info 地址信息，JSON格式
 * @property array $delivery_product_info 发货物流信息，JSON格式
 * @property int $ship_done_time 发货完成时间，秒级时间戳
 * @property int $deliver_method 订单发货方式，0：普通物流，1：虚拟发货
 * @property array $address_under_review 用户修改后的收货地址信息，JSON格式，覆盖订单地址信息
 * @property int $address_apply_time 修改地址申请时间，秒级时间戳
 * @property string $ewaybill_order_code 电子面单代发时的订单密文
 * @property int $quality_inspect_type 订单是否需要走新质检流程，1：需要；0：不需要
 * @property array $quality_inspect_info 质检信息，当quality_inspect_type为1时返回，JSON格式
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class WxcOrderDeliveryInfo extends MineModel
{
    protected string $primaryKey = 'order_id';
    /**
     * The table associated with the model.
     */
    protected ?string $table = 'wxc_order_delivery_info';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = ['order_id', 'site_id', 'app_id', 'address_info', 'delivery_product_info', 'ship_done_time', 'deliver_method', 'address_under_review', 'address_apply_time', 'ewaybill_order_code', 'quality_inspect_type', 'quality_inspect_info', 'created_at', 'updated_at'];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['order_id' => 'integer', 'site_id' => 'integer', 'ship_done_time' => 'integer', 'deliver_method' => 'integer', 'address_apply_time' => 'integer', 'quality_inspect_type' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime',
        'address_info' => 'array',
        'delivery_product_info' => 'array',
        'address_under_review' => 'array',
        'quality_inspect_info' => 'array',
    ];

    protected array $attributes = [
        'address_under_review' => '',
        'quality_inspect_info' => '',
    ];
}
