<?php
namespace App\Wxc\Dto;

use Mine\Interfaces\MineModelExcel;
use Mine\Annotation\ExcelData;
use Mine\Annotation\ExcelProperty;

/**
 * 订单Dto （导入导出）
 */
#[ExcelData]
class WxcOrderDto implements MineModelExcel
{
    #[ExcelProperty(value: "订单ID", index: 0)]
    public string $order_id;

    #[ExcelProperty(value: "租户ID", index: 1)]
    public string $site_id;

    #[ExcelProperty(value: "视频号小店ID", index: 2)]
    public string $app_id;

    #[ExcelProperty(value: "订单状态", index: 3)]
    public string $status;

    #[ExcelProperty(value: "买家身份标识", index: 4)]
    public string $openid;

    #[ExcelProperty(value: "created_at", index: 5)]
    public string $created_at;

    #[ExcelProperty(value: "updated_at", index: 6)]
    public string $updated_at;


}