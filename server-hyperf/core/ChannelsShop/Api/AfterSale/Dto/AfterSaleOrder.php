<?php

namespace Deepwell\ChannelsShop\Api\AfterSale\Dto;

use Carbon\Carbon;
use Deepwell\ChannelsShop\Api\AfterSale\Enums\AfterSaleStatus;
use Deepwell\ChannelsShop\Api\AfterSale\Enums\AfterSaleType;
use Deepwell\Data\Data;
use Deepwell\Data\Optional;

class AfterSaleOrder extends Data
{
    /**
     * 售后单号
     * @var string
     */
    public string $after_sale_order_id;

    /**
     * 售后单当前状态
     */
    public AfterSaleStatus $status;

    /**
     * 买家身份标识
     * @var string
     */
    public string $openid;

    /**
     * 买家在开放平台的唯一标识符，若当前视频号小店已绑定到微信开放平台账号下会返回
     * @var string
     */
    public string $unionid;

    /**
     * 售后相关商品信息
     */
    public AfterSaleProductInfo $product_info;

    /**
     * 售后详情
     */
    public AfterSaleDetails $details;

    /**
     * 退款详情
     */
    public RefundInfo|Optional $refund_info;

    /**
     * 用户退货信息
     */
    public ReturnInfo|Optional $return_info;

    /**
     * 商家上传的信息
     */
    public MerchantUploadInfo|Optional $merchant_upload_info;

    /**
     * 售后单创建时间
     */
    public Carbon $create_time;

    /**
     * 售后单更新时间
     */
    public Carbon $update_time;

    /**
     * 退款原因（后续新增的原因将不再有字面含义，请参考reason_text）
     * @var string
     */
    public string $reason;

    /**
     * 退款原因解释，全部定义参考获取全量售后原因
     * @var string
     */
    public string $reason_text;

    /**
     * 售后类型。REFUND:退款；RETURN:退货退款。
     */
    public AfterSaleType $type;

    /**
     * 纠纷id，该字段可用于获取纠纷信息
     */
    public string|Optional $complaint_id;

    /**
     * 订单号，该字段可用于获取订单
     * @var string
     */
    public string $order_id;

    /**
     * 微信支付退款的响应
     */
    public ApplyRefundResp|Optional $refund_resp;

    /**
     * 仅在待商家审核退款退货申请或收货期间返回，表示操作剩余时间（秒数）
     */
    public int|Optional $deadline;
}