<?php

declare(strict_types=1);

namespace App\Wxc\Model;

use Carbon\Carbon;
use Mine\MineModel;

/**
 * @property int $product_id 商品spuid
 * @property int $sku_id 商品skuid
 * @property int $order_id 订单ID
 * @property int $site_id 租户ID
 * @property string $app_id 视频号小店ID
 * @property int $sku_cnt sku数量
 * @property int $sale_price 售卖单价，单位为分
 * @property string $title 商品标题
 * @property int $on_aftersale_sku_cnt 正在售后/退款流程中的 sku 数量
 * @property int $finish_aftersale_sku_cnt 完成售后/退款的 sku 数量
 * @property string $sku_code 商品编码
 * @property int $market_price 市场单价，单位为分
 * @property array $sku_attrs sku属性，JSON格式
 * @property int $real_price sku实付总价，取estimate_price和change_price中较小值
 * @property string $out_product_id 商品外部spuid
 * @property string $out_sku_id 商品外部skuid
 * @property string $is_discounted 是否有优惠金额，非必填，默认为false
 * @property int $estimate_price 优惠后sku总价，非必填，is_discounted为true时有值
 * @property string $is_change_price 是否修改过价格，非必填，默认为false
 * @property int $change_price 改价后sku总价，非必填，is_change_price为true时有值
 * @property string $out_warehouse_id 区域库存id
 * @property array $sku_deliver_info 商品发货信息，JSON格式
 * @property array $extra_service 商品额外服务信息，JSON格式
 * @property string $use_deduction 是否使用了会员积分抵扣
 * @property int $deduction_price 会员积分抵扣金额，单位为分
 * @property array $order_product_coupon_info_list 商品优惠券信息，JSON格式
 * @property int $delivery_deadline 商品发货时效，超时此时间未发货即为发货超时
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class WxcOrderProductInfo extends MineModel
{
    protected string $primaryKey = 'product_id';
    /**
     * The table associated with the model.
     */
    protected ?string $table = 'wxc_order_product_info';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = ['product_id', 'sku_id', 'order_id', 'site_id', 'app_id', 'sku_cnt', 'sale_price', 'title', 'on_aftersale_sku_cnt', 'finish_aftersale_sku_cnt', 'sku_code', 'market_price', 'sku_attrs', 'real_price', 'out_product_id', 'out_sku_id', 'is_discounted', 'estimate_price', 'is_change_price', 'change_price', 'out_warehouse_id', 'sku_deliver_info', 'extra_service', 'use_deduction', 'deduction_price', 'order_product_coupon_info_list', 'delivery_deadline', 'created_at', 'updated_at'];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['product_id' => 'integer', 'sku_id' => 'integer', 'order_id' => 'integer', 'site_id' => 'integer', 'sku_cnt' => 'integer', 'sale_price' => 'integer', 'on_aftersale_sku_cnt' => 'integer', 'finish_aftersale_sku_cnt' => 'integer', 'market_price' => 'integer', 'real_price' => 'integer', 'estimate_price' => 'integer', 'change_price' => 'integer', 'deduction_price' => 'integer', 'delivery_deadline' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime',
        'sku_attrs' => 'array',
        'sku_deliver_info' => 'json',
        'extra_service' => 'json',
        'order_product_coupon_info_list' => 'json'
    ];
}
