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
 * 订单验证数据类
 */
class WxcOrderRequest extends MineFormRequest
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
            //订单状态 验证
            'status' => 'required',
            //买家身份标识 验证
            'openid' => 'required',

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
            //订单状态 验证
            'status' => 'required',
            //买家身份标识 验证
            'openid' => 'required',

        ];
    }

    
    /**
     * 字段映射名称
     * return array
     */
    public function attributes(): array
    {
        return [
            'order_id' => '订单ID',
            'site_id' => '租户ID',
            'app_id' => '视频号小店ID',
            'status' => '订单状态',
            'openid' => '买家身份标识',
            'created_at' => '',
            'updated_at' => '',

        ];
    }

}