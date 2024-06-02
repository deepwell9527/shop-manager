<?php

declare(strict_types=1);

namespace App\Wxc\Model;

use Carbon\Carbon;
use Mine\MineModel;

/**
 * @property int $order_id 订单ID
 * @property int $site_id 租户ID
 * @property string $app_id 视频号小店ID
 * @property string $prepay_id 预支付id
 * @property int $prepay_time 预支付时间，秒级时间戳
 * @property int $pay_time 支付时间，下单时间
 * @property string $transaction_id 支付订单号。先用后付订单(payment_method=2)在用户实际扣款前(确认收货时)本字段为空。对于抽奖0元订单(payment_method=3)或会员积分兑换订单(payment_method=4)，本字段为空
 * @property int $payment_method 支付方式。1：微信支付，2：先用后付，3：抽奖商品0元订单，4：会员积分兑换订单
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class WxcOrderPayInfo extends MineModel
{
    protected string $primaryKey = 'order_id';
    /**
     * The table associated with the model.
     */
    protected ?string $table = 'wxc_order_pay_info';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = ['order_id', 'site_id', 'app_id', 'prepay_id', 'prepay_time', 'pay_time', 'transaction_id', 'payment_method', 'created_at', 'updated_at'];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['order_id' => 'integer', 'site_id' => 'integer', 'prepay_time' => 'integer', 'pay_time' => 'integer', 'payment_method' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}
