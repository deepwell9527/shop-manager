<?php

declare(strict_types=1);

namespace App\Wxc\Model;

use Carbon\Carbon;
use Mine\MineModel;

/**
 * @property int $order_id 订单ID
 * @property int $site_id 租户ID
 * @property string $app_id 视频号小店ID
 * @property int $product_price 商品总价，单位为分
 * @property int $order_price 订单金额，单位为分，order_price=original_order_price-discounted_price-deduction_price-change_down_price
 * @property int $freight 运费，单位为分
 * @property int $discounted_price 优惠券优惠金额，单位为分
 * @property string $is_discounted 是否有优惠券优惠
 * @property int $original_order_price 订单原始价格，单位为分，original_order_price=product_price+freight
 * @property int $estimate_product_price 商品预估价格，单位为分
 * @property int $change_down_price 改价后降低金额，单位为分
 * @property int $change_freight 改价后运费，单位为分
 * @property string $is_change_freight 是否修改运费
 * @property string $use_deduction 是否使用了会员积分抵扣
 * @property int $deduction_price 会员积分抵扣金额，单位为分
 * @property Carbon $created_at 创建时间
 * @property Carbon $updated_at 修改时间
 */
class WxcOrderPriceInfo extends MineModel
{
    protected string $primaryKey = 'order_id';
    /**
     * The table associated with the model.
     */
    protected ?string $table = 'wxc_order_price_info';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = ['order_id', 'site_id', 'app_id', 'product_price', 'order_price', 'freight', 'discounted_price', 'is_discounted', 'original_order_price', 'estimate_product_price', 'change_down_price', 'change_freight', 'is_change_freight', 'use_deduction', 'deduction_price', 'created_at', 'updated_at'];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['order_id' => 'integer', 'site_id' => 'integer', 'product_price' => 'integer', 'order_price' => 'integer', 'freight' => 'integer', 'discounted_price' => 'integer', 'original_order_price' => 'integer', 'estimate_product_price' => 'integer', 'change_down_price' => 'integer', 'change_freight' => 'integer', 'deduction_price' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}
