<?php
declare(strict_types=1);

namespace Deepwell\ChannelsShop\Api\Order\Dto;

use Deepwell\ChannelsShop\Api\Product\Dto\SkuAttr;
use Deepwell\Data\Data;
use Deepwell\Data\Optional;

class ProductInfo extends Data
{
    /**
     * 商品spuid
     */
    public string $product_id;

    /**
     * 商品skuid
     */
    public string $sku_id;

    /**
     * sku小图
     */
    public string $thumb_img;

    /**
     * sku数量
     */
    public int $sku_cnt;

    /**
     * 售卖单价，单位为分
     */
    public int $sale_price;

    /**
     * 商品标题
     */
    public string $title;

    /**
     * 正在售后/退款流程中的 sku 数量
     */
    public int $on_aftersale_sku_cnt;

    /**
     * 完成售后/退款的 sku 数量
     */
    public int $finish_aftersale_sku_cnt;

    /**
     * 商品编码
     */
    public string $sku_code;

    /**
     * 市场单价，单位为分
     */
    public int $market_price;

    /**
     * sku属性
     * @var array<SkuAttr>
     */
    public array $sku_attrs;

    /**
     * sku实付总价，取estimate_price和change_price中较小值
     */
    public int $real_price;

    /**
     * 商品外部spuid
     */
    public string $out_product_id;

    /**
     * 商品外部skuid
     */
    public string $out_sku_id;

    /**
     * 是否有优惠金额，非必填，默认为false
     */
    public bool $is_discounted = false;

    /**
     * 优惠后sku总价，非必填，is_discounted为true时有值
     */
    public int|Optional $estimate_price;

    /**
     * 是否修改过价格，非必填，默认为false
     */
    public bool $is_change_price = false;

    /**
     * 改价后sku总价，非必填，is_change_price为true时有值
     */
    public int|Optional $change_price;

    /**
     * 区域库存id
     */
    public string $out_warehouse_id;

    /**
     * 商品发货信息
     */
    public SkuDeliverInfo $sku_deliver_info;

    /**
     * 商品额外服务信息
     */
    public ProductExtraService $extra_service;

    /**
     * 是否使用了会员积分抵扣
     */
    public bool $use_deduction = false;

    /**
     * 会员积分抵扣金额，单位为分
     */
    public int|Optional $deduction_price;

    /**
     * 商品优惠券信息
     * @var array<OrderProductCouponInfo>
     */
    public array $order_product_coupon_info_list;

    /**
     * 商品发货时效，超时此时间未发货即为发货超时
     */
    public int $delivery_deadline;
}