<?php

namespace Deepwell\ChannelsShop\Api\Order\Dto;

use Deepwell\Data\Data;

class PriceInfo extends Data
{
    /**
     * 商品总价，单位为分
     * @var int
     */
    public int $product_price;

    /**
     * 订单金额，单位为分，order_price=original_order_price-discounted_price-deduction_price-change_down_price
     * @var int
     */
    public int $order_price;

    /**
     * 运费，单位为分
     * @var int
     */
    public int $freight;

    /**
     * 优惠券优惠金额，单位为分
     * @var int
     */
    public int $discounted_price;

    /**
     * 是否有优惠券优惠
     * @var bool
     */
    public bool $is_discounted;

    /**
     * 订单原始价格，单位为分，original_order_price=product_price+freight
     * @var int
     */
    public int $original_order_price;

    /**
     * 商品预估价格，单位为分
     * @var int
     */
    public int $estimate_product_price;

    /**
     * 改价后降低金额，单位为分
     * @var int
     */
    public int $change_down_price;

    /**
     * 改价后运费，单位为分
     * @var int
     */
    public int $change_freight;

    /**
     * 是否修改运费
     * @var bool
     */
    public bool $is_change_freight;

    /**
     * 是否使用了会员积分抵扣
     * @var bool
     */
    public bool $use_deduction;

    /**
     * 会员积分抵扣金额，单位为分
     * @var int
     */
    public int $deduction_price;
}