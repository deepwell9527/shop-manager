<?php
declare(strict_types=1);

namespace Deepwell\ChannelsShop\Api\Order\Dto;

use Deepwell\Data\Data;
use Hyperf\Collection\Collection;

class OrderDetail extends Data
{
    /**
     * 商品列表
     * @var ProductInfo[]
     */
    public array $product_infos;

    /**
     * 价格信息
     */
    public PriceInfo $price_info;

    /**
     * 支付信息
     */
    public PayInfo $pay_info;

    /**
     * 配送信息
     */
    public DeliveryInfo $delivery_info;

    /**
     * 优惠券信息
     */
    public CouponInfo $coupon_info;

    /**
     * 额外信息
     */
    public ExtInfo $ext_info;

    /**
     * 分佣信息
     * @var CommissionInfo[]
     */
    public array $commission_infos;

    /**
     * 分享员信息
     */
    public SharerInfo $sharer_info;

    /**
     * 结算信息
     */
    public SettleInfo $settle_info;

    /**
     * 分享员信息
     * @var Collection<int,SkuSharerInfo>
     */
    public Collection $sku_sharer_infos;

    /**
     * 授权账号信息
     */
    public AgentInfo $agent_info;
}