<?php
declare(strict_types=1);
/**
 * MineAdmin is committed to providing solutions for quickly building web applications
 * Please view the LICENSE file that was distributed with this source code,
 * For the full copyright and license information.
 * Thank you very much for using MineAdmin.
 *
 * @Author X.Mo<root@imoi.cn>
 * @Link   https://gitee.com/xmo/MineAdmin
 */
namespace App\Wxc\Request;

use Mine\MineFormRequest;

/**
 * 售后管理验证数据类
 */
class WxcAfterSaleRequest extends MineFormRequest
{
    /**
     * 公共规则
     */
    public function commonRules(): array
    {
        return [];
    }

    
    /**
     * 新增数据验证规则
     * return array
     */
    public function saveRules(): array
    {
        return [
            //租户ID 验证
            'site_id' => 'required',
            //视频号小店ID 验证
            'app_id' => 'required',
            //售后单当前状态 验证
            'status' => 'required',
            //买家身份标识 验证
            'openid' => 'required',
            //买家在开放平台的唯一标识符 验证
            'unionid' => 'required',
            //售后相关商品信息 验证
            'product_info' => 'required',
            //售后详情 验证
            'details' => 'required',
            //退款详情 验证
            'refund_info' => 'required',
            //用户退货信息 验证
            'return_info' => 'required',
            //商家上传的信息 验证
            'merchant_upload_info' => 'required',
            //退款原因 验证
            'reason' => 'required',
            //退款原因解释 验证
            'reason_text' => 'required',
            //售后类型 验证
            'type' => 'required',
            //纠纷id 验证
            'complaint_id' => 'required',
            //订单号 验证
            'order_id' => 'required',
            //微信支付退款的响应 验证
            'refund_resp' => 'required',
            //操作剩余时间（秒数） 验证
            'deadline' => 'required',

        ];
    }
    /**
     * 更新数据验证规则
     * return array
     */
    public function updateRules(): array
    {
        return [
            //租户ID 验证
            'site_id' => 'required',
            //视频号小店ID 验证
            'app_id' => 'required',
            //售后单当前状态 验证
            'status' => 'required',
            //买家身份标识 验证
            'openid' => 'required',
            //买家在开放平台的唯一标识符 验证
            'unionid' => 'required',
            //售后相关商品信息 验证
            'product_info' => 'required',
            //售后详情 验证
            'details' => 'required',
            //退款详情 验证
            'refund_info' => 'required',
            //用户退货信息 验证
            'return_info' => 'required',
            //商家上传的信息 验证
            'merchant_upload_info' => 'required',
            //退款原因 验证
            'reason' => 'required',
            //退款原因解释 验证
            'reason_text' => 'required',
            //售后类型 验证
            'type' => 'required',
            //纠纷id 验证
            'complaint_id' => 'required',
            //订单号 验证
            'order_id' => 'required',
            //微信支付退款的响应 验证
            'refund_resp' => 'required',
            //操作剩余时间（秒数） 验证
            'deadline' => 'required',

        ];
    }

    
    /**
     * 字段映射名称
     * return array
     */
    public function attributes(): array
    {
        return [
            'after_sale_order_id' => '售后单号',
            'site_id' => '租户ID',
            'app_id' => '视频号小店ID',
            'status' => '售后单当前状态',
            'openid' => '买家身份标识',
            'unionid' => '买家在开放平台的唯一标识符',
            'product_info' => '售后相关商品信息',
            'details' => '售后详情',
            'refund_info' => '退款详情',
            'return_info' => '用户退货信息',
            'merchant_upload_info' => '商家上传的信息',
            'reason' => '退款原因',
            'reason_text' => '退款原因解释',
            'type' => '售后类型',
            'complaint_id' => '纠纷id',
            'order_id' => '订单号',
            'refund_resp' => '微信支付退款的响应',
            'deadline' => '操作剩余时间（秒数）',
            'created_at' => '售后单创建时间戳',
            'updated_at' => '售后单更新时间戳',

        ];
    }

}