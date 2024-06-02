<?php

namespace Deepwell\ChannelsShop\Api\Order\Dto;

use Deepwell\ChannelsShop\Api\Order\Enums\PaymentMethod;
use Deepwell\Data\Data;

class PayInfo extends Data
{
    /**
     * 预支付id
     * @var string
     */
    public string $prepay_id;

    /**
     * 预支付时间，秒级时间戳
     * @var int
     */
    public int $prepay_time;

    /**
     * 支付时间，秒级时间戳。先用后付订单(payment_method=2)本字段的值为用户确认先用后付订单的时间，
     * 抽奖0元订单(payment_method=3)或者会员积分兑换订单(payment_method=4)没有发生实际支付，本字段的值为下单时间
     * @var int
     */
    public int $pay_time;

    /**
     * 支付订单号，先用后付订单(payment_method=2)在用户实际扣款前(确认收货时)本字段为空，
     * 抽奖0元订单(payment_method=3)或者会员积分兑换订单(payment_method=4)本字段为空
     * @var string
     */
    public string $transaction_id;

    /**
     * 支付方式，已支付订单会返回本字段，具体枚举值请参考PaymentMethod枚举
     * @var PaymentMethod
     */
    public PaymentMethod $payment_method;
}