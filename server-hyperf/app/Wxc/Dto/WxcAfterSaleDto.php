<?php
namespace App\Wxc\Dto;

use Mine\Interfaces\MineModelExcel;
use Mine\Annotation\ExcelData;
use Mine\Annotation\ExcelProperty;

/**
 * 售后管理Dto （导入导出）
 */
#[ExcelData]
class WxcAfterSaleDto implements MineModelExcel
{
    #[ExcelProperty(value: "售后单号", index: 0)]
    public string $after_sale_order_id;

    #[ExcelProperty(value: "租户ID", index: 1)]
    public string $site_id;

    #[ExcelProperty(value: "视频号小店ID", index: 2)]
    public string $app_id;

    #[ExcelProperty(value: "售后单当前状态", index: 3)]
    public string $status;

    #[ExcelProperty(value: "买家身份标识", index: 4)]
    public string $openid;

    #[ExcelProperty(value: "买家在开放平台的唯一标识符", index: 5)]
    public string $unionid;

    #[ExcelProperty(value: "售后相关商品信息", index: 6)]
    public string $product_info;

    #[ExcelProperty(value: "售后详情", index: 7)]
    public string $details;

    #[ExcelProperty(value: "退款详情", index: 8)]
    public string $refund_info;

    #[ExcelProperty(value: "用户退货信息", index: 9)]
    public string $return_info;

    #[ExcelProperty(value: "商家上传的信息", index: 10)]
    public string $merchant_upload_info;

    #[ExcelProperty(value: "退款原因", index: 11)]
    public string $reason;

    #[ExcelProperty(value: "退款原因解释", index: 12)]
    public string $reason_text;

    #[ExcelProperty(value: "售后类型", index: 13)]
    public string $type;

    #[ExcelProperty(value: "纠纷id", index: 14)]
    public string $complaint_id;

    #[ExcelProperty(value: "订单号", index: 15)]
    public string $order_id;

    #[ExcelProperty(value: "微信支付退款的响应", index: 16)]
    public string $refund_resp;

    #[ExcelProperty(value: "操作剩余时间（秒数）", index: 17)]
    public string $deadline;

    #[ExcelProperty(value: "售后单创建时间戳", index: 18)]
    public string $created_at;

    #[ExcelProperty(value: "售后单更新时间戳", index: 19)]
    public string $updated_at;


}